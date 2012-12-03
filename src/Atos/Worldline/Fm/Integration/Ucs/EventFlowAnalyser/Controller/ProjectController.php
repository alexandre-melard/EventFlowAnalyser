<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

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
                $key = sprintf('%09d', mt_rand(0, 1999999999));
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
     * @Template("UcsEventFlowAnalyser:Project:edit.html.twig")
     */
    public function createAction()
    {
        list($key, $tmp_dir) = $this->createTmp();
        
        $project = new Project($this->getUser());
        $form = $this->createForm(new ProjectType(), $project);
        
        return array('form' => $form->createView(), 'key' => $key);
    }
    
    /**
     * @Route("/delete/{visibility}/{name}", name="projects_delete")
     * @Method({"GET"})
     * @Template
     */
    public function deleteAction($visibility, $name)
    {
        try {
            /* @var $projectDao ProjectDao */
            $projectDao = $this->get('app.project_dao');
            
            try {
                /* @var $project Project */
                $project = $projectDao->get($this->getUser(), $visibility, $name);
            } catch (NoResultException $e) {
                $this->get('session')->getFlashBag()->add('error', "Project $name ($visibility) could not be removed because it wasn't found!");
            }
            
            /* will remove also the FS files thanks to postRemove callback :o) */
            $projectDao->remove($project);
            $projectDao->flush();
        } catch (Exception $e) {
            $this->get('session')->getFlashBag()->add('error', "Project $name ($visibility) could not be removed [" . $e->getMessage() . "]");
        }
        $this->get('session')->getFlashBag()->add('success', "Project $name ($visibility) has been removed successfully");
        
        return $this->redirect($this->generateUrl('projects_default'));
    }
    
    /**
     * @Route("/edit/{visibility}/{name}", name="projects_edit")
     * @Method({"GET"})
     * @Template
     */
    public function editAction($visibility, $name)
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploadDir = $uploader->getFileBasePath();
        
        list($key, $tmp_dir) = $this->createTmp();

        $projectDao = $this->get('app.project_dao');
        $project = $projectDao->get($this->getUser(), $visibility, $name);
        
        $form = $this->createForm(new ProjectEditType(), $project);

        $form->get('original_name')->setData($project->getName());
        $form->get('original_visibility')->setData($project->getVisibility());
        
        /* @var $projectService ProjectService */
        $projectService = $this->get('app.project');
        
        // mirror data_dir so that the user can edit current files
        $data_dir = $projectService->getDataDir($project, $uploadDir);
        $fs = new Filesystem();
        if ($fs->exists($data_dir)) {
            $fs->mirror($data_dir, $tmp_dir);
        }

        return array('form' => $form->createView(), 'key' => $key);
    }
    
    /**
     * @Route("/error/{visibility}/{name}/{key}", name="projects_error")
     * @Method({"GET"})
     * @Template
     */
    public function errorAction($visibility, $name, $key)
    {
        list($key, $tmp_dir) = $this->createTmp($key);
    
        $project = new Project($this->getUser());
    
        $project->setName($name);
        $project->setVisibility($visibility);
    
        $form = $this->createForm(new FileEditType(), $project);
    
        $form->get('original_name')->setData($project->getName());
        $form->get('original_visibility')->setData($project->getVisibility());
    
        /* @var $projectService ProjectService */
        $projectService = $this->get('app.project');
        
        // mirror data_dir so that the user can edit current files
        $data_dir = $projectService->getDataDir($project, $uploadDir);
        $fs = new Filesystem();
        if ($fs->exists($data_dir)) {
            $fs->mirror($data_dir, $tmp_dir);
        }
    
        return array('form' => $form->createView(), 'key' => $key);
    }
    
    /**
     * @Route("/edit/{key}", name="projects_save")
     * @Method({"POST", "PUT", "PATCH"})
     */
    public function saveAction($key)
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploadDir = $uploader->getFileBasePath();
        $webDir = $uploader->getWebBasePath();

        $project = new Project($this->getUser());
        
        /* @var $form Form */
        $form = $this->createForm(new ProjectEditType(), $project);
        
        $form->bind($this->getRequest());
        
        if ($form->isValid()) {
            $fs = new Filesystem();
            if ($form->has('edit')) {
                $original_name = $form->get('original_name')->getData();
                $original_visibility = $form->get('original_visibility')->getData();
            }
            /* @var $projectService ProjectService */
            $projectService = $this->get('app.project');
            $projectService->setParserService($this->get('app.parser'));
            $project->setProjectService($projectService);
            
            $project->setPath($projectService->getDataDir($project, $uploadDir));
            $project->setWebPath($projectService->getDataDir($project, $webDir));
            $project->setTmp($uploadDir . '/tmp/' . $key . '/originals');
            
            // Populate project with documents and so forth
            $project = $projectService->populate($project);
            
            /* @var $projectDao ProjectDao */
            $projectDao = $this->get('app.project_dao');
            $projectDao->persist($project);            
            $projectDao->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'File upload as been completed!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'File upload could not be completed... Please check form values and retry');
        }

        return $this->redirect($this->generateUrl('projects_edit', array('visibility' => $project->getVisibility(), 'name' => $project->getName())));
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

        return array('projects' => $projectDao->getAllByUser($this->getUser()));
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
        if (!preg_match('/^\d+$/', $key)) {
            throw new \Exception("Bad edit id");
        }
        
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
        /* @var $uploader IResponseContainer */
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
