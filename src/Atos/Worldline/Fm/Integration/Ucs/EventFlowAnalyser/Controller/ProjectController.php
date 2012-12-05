<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Ext\Uploader\UploadHandler;

use Doctrine\ORM\NoResultException;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Uploader\XmlUploadHandlerFactory;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\ProjectDao;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Form\Form;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Mylen\JQueryFileUploadBundle\Services\FileUploader;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ProjectService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\FileService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Form\ProjectType;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Form\ProjectEditType;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Uploader\XmlUploadHandler;


/**
 * @Route("/projects")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/", name="projects_default")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    protected function createTmp($key = null)
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploadDir = $uploader->getFileBasePath();

        $fs = new Filesystem();
        if ($key === null) {
            do {
                // Build unique ID
                $key = sha1(uniqid(mt_rand(), true));
            } while ($fs->exists($uploadDir . '/tmp/' . $key));
        }

        // Create temporary directory where the user will be able to play with the files
        $tmp_dir = $uploadDir . '/tmp/' . $key;
        $fs->mkdir($tmp_dir);
        $tmp_dir .= '/originals';
        $fs->mkdir($tmp_dir);

        return array($key, $tmp_dir);
    }

    
    /**
     * @Route("/create/", name="projects_create")
     * @Method({"GET"})
     * @Template
     */
    public function createAction()
    {
        list($key, $tmp_dir) = $this->createTmp();
        
        $project = new Project($this->getUser());
        $form = $this->createForm(new ProjectType(), $project);
        
        return array('form' => $form->createView(), 'actionTarget' => 'create', 'key' => $key);
    }

    /**
     * @Route("/create/{key}", name="projects_create_save")
     * @Method({"POST", "PUT", "PATCH"})
     */
    public function createSaveAction($key)
    {
        /* @var $project Project */
        $project = new Project($this->getUser());

        /* @var $form Form */
        $form = $this->createForm(new ProjectType(), $project);

        $form->bind($this->getRequest());

        if ($form->isValid()) {

            /* @var $projectService ProjectService */
            $projectService = $this->get('app.project');
            $project->setProjectService($projectService);
            
            /* @var $uploader FileUploader */
            $uploader = $this->get('mylen.file_uploader');
            $uploadDir = $uploader->getFileBasePath();
            
            $project->setKey($key);
            $project->setPath($projectService->getDataDir($project, $uploadDir));
            $project->setWebPath($projectService->getDataDir($project, $uploader->getWebBasePath()));
            $project->setTmp($projectService->getTmpDir($project, $uploader->getFileBasePath()));
            
            // Populate project with documents and so forth
            $project = $projectService->populate($project);
    
            /* @var $projectDao ProjectDao */
            $projectDao = $this->get('app.project_dao');
            $projectDao->persist($project);
            $projectDao->flush();
            
            // clean up tmp dir
            $projectService->removeDir($project->getTmp());
            
            $this->get('session')->getFlashBag()->add('success', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') creation as been completed!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') could not be completed... Please check form values and retry');
        }
    
        return $this->redirect($this->generateUrl('projects_edit', array('visibility' => $project->getVisibility(), 'name' => $project->getName())));
    }
    /**
     * @Route("/edit/{visibility}/{name}", name="projects_edit")
     * @Method({"GET"})
     * @Template
     */
    public function editAction($visibility, $name)
    {
        list($key, $tmp_dir) = $this->createTmp();

        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        $project = $projectDao->get($this->getUser(), $visibility, $name);
        
        /* @var $projectService ProjectService */
        $projectService = $this->get('app.project');
        $project->setProjectService($projectService);
        
        $form = $this->createForm(new ProjectEditType(), $project);

        $form->get('original_name')->setData($project->getName());
        $form->get('original_visibility')->setData($project->getVisibility());

        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        
        // mirror data_dir so that the user can edit current files
        $data_dir = $projectService->getDataDir($project, $uploader->getFileBasePath());
        $projectService->dataToTmp($project, $data_dir, $tmp_dir);

        return array('form' => $form->createView(), 'actionTarget' => 'edit', 'key' => $key);
    }
    
    /**
     * @Route("/edit/{key}", name="projects_edit_save")
     * @Method({"POST", "PUT", "PATCH"})
     */
    public function editSaveAction($key)
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        
        /* @var $project Project */
        $project = new Project($this->getUser());
        
        /* @var $form Form */
        $form = $this->createForm(new ProjectEditType(), $project);
        
        $form->bind($this->getRequest());
        
        if ($form->isValid()) {

            /* @var $projectService ProjectService */
            $projectService = $this->get('app.project');
            $project->setProjectService($projectService);
            
            /* @var $uploader FileUploader */
            $uploader = $this->get('mylen.file_uploader');
            
            $project->setKey($key);
            $project->setPath($projectService->getDataDir($project, $uploader->getFileBasePath()));
            $project->setWebPath($projectService->getDataDir($project, $uploader->getWebBasePath()));
            $project->setTmp($projectService->getTmpDir($project, $uploader->getFileBasePath()));
            
            // Populate project with documents and so forth
            $project = $projectService->populate($project);
            
            $projectDao->persist($project);            
            
            // Removing Old Project
            $original_name = $form->get('original_name')->getData();
            $original_visibility = $form->get('original_visibility')->getData();
            $project_old = $projectDao->get($this->getUser(), $original_visibility, $original_name);
            $project_old->setProjectService($projectService);
            
            $projectDao->remove($project_old);
            
            $projectDao->flush();
            
            // clean up tmp dir (.../data/tmp/XXX/original/../)
            $projectService->removeDir($project->getTmp() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
            
            $this->get('session')->getFlashBag()->add('success', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') creation as been completed!');
            $this->get('session')->getFlashBag()->add('success', 'Project ' . $project_old->getName() . '(' . $project_old->getVisibility() . ') removal as been completed!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') could not be completed... Please check form values and retry');
        }

        return $this->redirect($this->generateUrl('projects_edit', array('visibility' => $project->getVisibility(), 'name' => $project->getName())));
    }
    
    /**
     * @Route("/delete/{visibility}/{name}", name="projects_delete")
     * @Method({"GET"})
     * @Template
     */
    public function deleteAction($visibility, $name)
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
    
        try {
            /* @var $project Project */
            $project = $projectDao->get($this->getUser(), $visibility, $name);
            $project->setProjectService($this->get('app.project'));
    
            /* will remove also the FS files thanks to postRemove callback :o) */
            $projectDao->remove($project);
            $projectDao->flush();
    
        } catch (NoResultException $e) {
            $this->get('session')->getFlashBag()->add('error', "Project $name ($visibility) could not be removed because it wasn't found!");
        } catch (Exception $e) {
            $this->get('session')->getFlashBag()->add('error', "Project $name ($visibility) could not be removed [" . $e->getMessage() . "]");
        }
        $this->get('session')->getFlashBag()->add('success', "Project $name ($visibility) has been removed successfully");
    
        return $this->redirect($this->container->get('request')->getReferer());
    }
    
    /**
     * @Route("/list/all", name="projects_list_all")
     * @Method({"GET"})
     * @Template
     */
    public function listAllAction()
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');

        $public = $projectDao->getAllByVisibility($this->getUser(), 'public');
        $private = $projectDao->getAllByVisibility($this->getUser(), 'private');
        
        return array(
                'public' => $public,
                'private' => $private
                );
    }
    
    /**
     * @Route("/list/{visibility}", name="projects_list")
     * @Method({"GET"})
     * @Template
     */
    public function listAction($visibility)
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');

        return array(
                'projects'   => $projectDao->getAllByVisibility($this->getUser(), $visibility), 
                'visibility' => $visibility);
    }

    /**
     * 
     * @param string $key
     * @throws \Exception
     * @return \Mylen\JQueryFileUploadBundle\Services\IResponseContainer
     */
    protected function handleRequest($key)
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploader->setUploadHandlerFactory(new XmlUploadHandlerFactory($this->container->getParameter('app.event_xsd')));        
        return $uploader->handleFileUpload('tmp/' . $key);
    }

    /**
     *
     * @Route("/upload/{key}", name="projects_put")
     * @Method({"PATCH", "POST", "PUT"})
     */
    public function putAction($key)
    {
        /* @var $uploader XmlUploadHandler */
        $uploader = $this->handleRequest($key);
        $uploader->post();
        
        return new Response($uploader->getBody(), $uploader->getType(), $uploader->getHeader());
    }

    /**
     *
     * @Route("/upload/{key}", name="projects_head")
     * @Method("HEAD")
     */
    public function headAction($key)
    {
        /* @var $uploader IResponseContainer */
        $uploader = $this->handleRequest($key);
        $uploader->head();

        return new Response($uploader->getBody(), $uploader->getType(), $uploader->getHeader());
    }

    /**
     *
     * @Route("/upload/{key}", name="projects_get")
     * @Method("GET")
     */
    public function getAction($key)
    {
        /* @var $uploader IResponseContainer */
        $uploader = $this->handleRequest($key);
        $uploader->get();
        
        return new Response($uploader->getBody(), $uploader->getType(), $uploader->getHeader());
    }

    /**
     *
     * @Route("/upload/{key}", name="projects_delete_file")
     * @Method("DELETE")
     */
    public function deleteProjectAction($key)
    {
        /* @var $uploader IResponseContainer */
        $uploader = $this->handleRequest($key);
        $uploader->delete();

        return new Response($uploader->getBody(), $uploader->getType(), $uploader->getHeader());
    }
}
