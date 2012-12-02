<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

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

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\FileService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Form\FileType;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Form\FileEditType;


/**
 * @Route("/files")
 */
class FileController extends Controller
{
    /**
     * @Route("/", name="files_default")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    protected function getDataDir($visibility, $soft = '')
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploadDir = $uploader->getFileBasePath();

        return $uploadDir . '/data/' . $visibility . DIRECTORY_SEPARATOR . $this->getUser()->getSalt() . DIRECTORY_SEPARATOR . $soft;
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
     * @Route("/create/", name="files_create")
     * @Method({"GET"})
     * @Template("UcsEventFlowAnalyser:File:edit.html.twig")
     */
    public function createAction()
    {
        list($key, $tmp_dir) = $this->createTmp();
        
        $project = new Project($this->getUser());
        $form = $this->createForm(new FileType(), $project);
        
        return array('form' => $form->createView(), 'key' => $key);
    }

    /**
     * @Route("/edit/{visibility}/{soft}", name="files_edit")
     * @Method({"GET"})
     * @Template
     */
    public function editAction($visibility, $soft)
    {
        list($key, $tmp_dir) = $this->createTmp();
        $projectDao = $this->get('app.project_dao');
        $project = $this->getDoctrine()
            ->getRepository('UcsEventFlowAnalyser:Project')
            ->findOneBy(
                    array(
                            'user' => $this->getUser()->getId(), 
                            'visibility' => $visibility, 
                            'name' => $soft
                         )
                    );
        
        $form = $this->createForm(new FileEditType(), $project);

        $form->get('original_name')->setData($project->getName());
        $form->get('original_visibility')->setData($project->getVisibility());
        
        // mirror data_dir so that the user can edit current files
        $data_dir = $this->getDataDir($project->getVisibility(), $project->getName());
        $fs = new Filesystem();
        if ($fs->exists($data_dir)) {
            $fs->mirror($data_dir, $tmp_dir);
        }

        return array('form' => $form->createView(), 'key' => $key);
    }
    
    /**
     * @Route("/error/{visibility}/{soft}/{key}", name="files_error")
     * @Method({"GET"})
     * @Template
     */
    public function errorAction($visibility, $soft, $key)
    {
        list($key, $tmp_dir) = $this->createTmp($key);
    
        $project = new Project($this->getUser());
    
        $project->setName($soft);
        $project->setVisibility($visibility);
    
        $form = $this->createForm(new FileEditType(), $project);
    
        $form->get('original_name')->setData($project->getName());
        $form->get('original_visibility')->setData($project->getVisibility());
    
        // mirror data_dir so that the user can edit current files
        $data_dir = $this->getDataDir($project->getVisibility(), $project->getName());
        $fs = new Filesystem();
        if ($fs->exists($data_dir)) {
            $fs->mirror($data_dir, $tmp_dir);
        }
    
        return array('form' => $form->createView(), 'key' => $key);
    }
    
    /**
     * @Route("/edit/{key}", name="files_save")
     * @Method({"POST", "PUT", "PATCH"})
     */
    public function saveAction($key)
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploadDir = $uploader->getFileBasePath();

        $project = new Project($this->getUser());
        
        /* @var $form Form */
        $form = $this->createForm(new FileEditType(), $project);
        
        $form->bind($this->getRequest());
        
        if ($form->isValid()) {
            $fs = new Filesystem();
            if ($form->has('edit')) {
                $original_name = $form->get('original_name')->getData();
                $original_visibility = $form->get('original_visibility')->getData();
                $data_dir = $this->getDataDir($original_visibility, $original_name);
                
                if ($fs->exists($data_dir)) {
                    $fs->remove($data_dir);
                }
            }
            
            $project->setPath($this->getDataDir($project->getVisibility(), $project->getName()));
            $project->setTmp($uploadDir . '/tmp/' . $key . '/originals');
            $project->setParserService($this->get('app.parser'));
            
            try {
                $fs->mirror($project->getTmp(), $project->getPath());
                $fs->remove($project->getTmp());
                $fs->remove($project->getTmp() . "/../");
            } catch (Exception $e) {
                $fs->remove($project->getTmp());
                $fs->remove($project->getTmp() . "/../");
                throw $e;
            } 
            $project->populate();
            
            /* @var $projectDao ProjectDao */
            $projectDao = $this->get('app.project_dao');
            $projectDao->persist($project);            
            $projectDao->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'File upload as been completed!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'File upload could not be completed... Please check form values and retry');
        }

        return $this->redirect($this->generateUrl('files_edit', array('visibility' => $project->getVisibility(), 'soft' => $project->getName())));
    }
    
    /**
     * @Route("/list/all", name="files_list_all")
     * @Method({"GET"})
     * @Template
     */
    public function listAllAction()
    {
        /* returned files */
        $files = array();
    
        /* @var $fs Filesystem */
        $fs = new Filesystem();
    
        foreach ( array('public', 'private') as $visibility ) {
            $dir = $this->getDataDir($visibility);
            if ($fs->exists($dir)) {
                $files[$visibility] = array();
    
                /* @var $finder Finder */
                $finder = Finder::create()->files()->in($dir);
    
                foreach ($finder->directories() as $entry) {
                    /* @var $entry SplFileInfo */
                    $files[$visibility][$entry->getRelativePathname()] = array();
                }
                foreach ($finder->name('*.xml')->files() as $entry) {
                    array_push($files[$visibility][$entry->getRelativePath()], $entry->getFilename());
                }
            }
        }
    
        return array('files' => $files);
    }
    
    /**
     * @Route("/list/{visibility}", name="files_list")
     * @Method({"GET"})
     * @Template
     */
    public function listAction($visibility)
    {
        /* returned files */
        $files = array();
    
        /* @var $fs Filesystem */
        $fs = new Filesystem();
        $data_dir = $this->getDataDir($visibility);
        if ($fs->exists($data_dir)) {
    
            /* @var $finder Finder */
            $finder = Finder::create()->files()->in($data_dir);
    
            foreach ($finder->directories() as $entry) {
                /* @var $entry SplFileInfo */
                $files[$entry->getRelativePathname()] = array();
            }
            foreach ($finder->name('*.xml')->files() as $entry) {
                array_push($files[$entry->getRelativePath()], $entry->getFilename());
            }
        }
    
        return array('files' => $files, 'visibility' => $visibility);
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
        if (!preg_match('/^\d+$/', $key)) {
            throw new \Exception("Bad edit id");
        }
        return $uploader->handleFileUpload('tmp/' . $key);
    }

    /**
     *
     * @Route("/upload/{key}", name="files_put")
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
     * @Route("/upload/{key}", name="files_head")
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
     * @Route("/upload/{key}", name="files_get")
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
     * @Route("/upload/{key}", name="files_delete")
     * @Method("DELETE")
     */
    public function deleteAction($key)
    {
        /* @var $uploader IResponseContainer */
        $uploader = $this->handleRequest($key);
        $uploader->delete();

        return new Response($uploader->getBody(), $uploader->getType(), $uploader->getHeader());
    }

    /**
     * @Route("/all", name="files_all")
     * @Template
     */
    public function allAction()
    {
        /** @var FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $dir = $this->getUser()->getSalt();
        $path = $this->get('kernel')->locateResource('@UcsEventFlowAnalyser/Resources/data/' . $dir);
        $files = $this->get('app.file')->scanDir($path);

        return array("title" => "Display All Files", "private" => $files['private'], "public" => $files['public']);
    }
}
