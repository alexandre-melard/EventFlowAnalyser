<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\EventFlowService;

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
        return array(
                'title' => 'Accueil',
                    );
    }
    
    /**
     * @Route("/create", name="projects_create")
     * @Method({"GET"})
     * @Template
     */
    public function createAction()
    {
        /* @var $projectService ProjectService */
        $projectService = $this->get('app.project');

        /* create new porject for current user */
        $project = new Project($this->getUser());
        $project = $projectService->createTmp($project);
        
        $form = $this->createForm(new ProjectType(), $project);
        
        return array(
                'title' => 'Create new project',
                'form' => $form->createView(), 
                'actionTarget' => 'create',
                'key' => $project->getKey()
                );
    }

    /**
     * @Route("/create", name="projects_create_save")
     * @Method({"POST", "PUT", "PATCH"})
     */
    public function createSaveAction()
    {
        /* @var $project Project */
        $project = new Project($this->getUser());

        /* @var $form Form */
        $form = $this->createForm(new ProjectType(), $project);

        $form->bind($this->getRequest());

        if ($form->isValid()) {

            /* @var $projectService ProjectService */
            $projectService = $this->get('app.project');
            
            /* Populate project with documents and so forth */
            $project = $projectService->populate($project, new Finder());
                
            $this->get('session')->getFlashBag()->add('success', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') creation as been completed!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') could not be completed... Please check form values and retry');
        }
    
        return $this->redirect($this->generateUrl('projects_edit', array('name' => $project->getName())));
    }
    /**
     * @Route("/edit/{name}", name="projects_edit")
     * @Method({"GET"})
     * @Template
     */
    public function editAction($name)
    {

        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        $project = $projectDao->get($this->getUser(), $name);
        
        /* @var $projectService ProjectService */
        $projectService = $this->get('app.project');
        $project->setProjectService($projectService);

        $project = $projectService->createTmp($project);

        /* Create from with extra edit fixtures */
        $form = $this->createForm(new ProjectEditType(), $project);
        $form->get('original_name')->setData($project->getName());
        $form->get('original_visibility')->setData($project->getVisibility());

        // mirror data_dir so that the user can edit current files
        $projectService->dataToTmp($project);

        return array(
                'title' => 'Edit ' . $project->getName(),
                'form' => $form->createView(), 
                'actionTarget' => 'edit',
                'key' => $project->getKey()
                );
    }
    
    /**
     * @Route("/edit", name="projects_edit_save")
     * @Method({"POST", "PUT", "PATCH"})
     */
    public function editSaveAction($key)
    {
        /* @var $project Project */
        $project = new Project($this->getUser());
        
        /* @var $form Form */
        $form = $this->createForm(new ProjectEditType(), $project);
        
        $form->bind($this->getRequest());
        
        if ($form->isValid()) {

            /* @var $projectService ProjectService */
            $projectService = $this->get('app.project');
            
            // Populate project with documents and so forth
            $project = $projectService->populate($project);

            /*
             * Removing Old Project 
             ***********************/

            /* @var $projectDao ProjectDao */
            $projectDao = $this->get('app.project_dao');
            $project_old = $projectDao->get(
                    $this->getUser(), 
                    $form->get('original_name')->getData()
                    );
            $project_old->setProjectService($projectService);
            $projectDao->remove($project_old);
            $projectDao->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') creation as been completed!');
            $this->get('session')->getFlashBag()->add('success', 'Project ' . $project_old->getName() . '(' . $project_old->getVisibility() . ') removal as been completed!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') could not be completed... Please check form values and retry');
        }

        return $this->redirect($this->generateUrl('projects_edit', array('name' => $project->getName())));
    }
    
    /**
     * @Route("/delete/{name}", name="projects_delete")
     * @Method({"GET"})
     * @Template
     */
    public function deleteProjectAction($name)
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
    
        try {
            /* @var $project Project */
            $project = $projectDao->get($this->getUser(), $name);
            $project->setProjectService($this->get('app.project'));
    
            /* will remove also the FS files thanks to postRemove callback :o) */
            $projectDao->remove($project);
            $projectDao->flush();
    
        } catch (NoResultException $e) {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $name . '(' . $project->getVisibility() . ' could not be removed because it was not found!');
        } catch (Exception $e) {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $name . '(' . $project->getVisibility() . ' could not be removed [' . $e->getMessage() . ']');
        }
        $this->get('session')->getFlashBag()->add('success', 'Project ' . $name . '(' . $project->getVisibility() . ' has been removed successfully');
    
        return $this->redirect($this->container->get('request')->server->get("HTTP_REFERER"));
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
                'title' => 'List all projects',
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
                'title' => 'List all ' . $visibility  . ' projects',
                'projects'   => $projectDao->getAllByVisibility($this->getUser(), $visibility),
                'visibility' => $visibility);
    }
    
    /**
     * @Route("/documents/{projectName}/{documentName}", name="projects_documents_document")
     * @Method({"GET"})
     * @Template
     */
    public function documentAction($projectName, $documentName)
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        
        /* @var $documents array Document */
        $documents = $projectDao->get($this->getUser(), urldecode($projectName))->getDocuments();

        /* @var $document Document */
        foreach ($documents as $document) {
            if ($document->getName() == urldecode($documentName)) {
                break;
            }
        }
        $content = file_get_contents($document->getPath());
        
        return array(
                'title' =>$document->getName(),
                'document' => $document,
                'content' => $content
                );
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
    public function deleteFileAction($key)
    {
        /* @var $uploader IResponseContainer */
        $uploader = $this->handleRequest($key);
        $uploader->delete();

        return new Response($uploader->getBody(), $uploader->getType(), $uploader->getHeader());
    }
}
