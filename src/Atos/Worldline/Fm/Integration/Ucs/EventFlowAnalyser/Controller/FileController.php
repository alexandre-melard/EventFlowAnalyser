<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Symfony\Component\Form\Form;

use Symfony\Component\Filesystem\Filesystem;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Config\Definition\Exception\Exception;
use Mylen\JQueryFileUploadBundle\Services\FileUploader;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\FileService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Symfony\Component\HttpFoundation\Response;

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

    protected function getDataDir($visibility, $soft)
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploadDir = $uploader->getFileBasePath();

        return $uploadDir . '/data/' . $visibility . DIRECTORY_SEPARATOR . $this->getUser()->getSalt() . DIRECTORY_SEPARATOR . $soft;
    }

    /**
     * @Route("/create/", name="files_create")
     * @Method({"GET"})
     * @Template
     */
    public function createAction()
    {
        return $this->redirect($this->generateUrl('files_edit', array('visibility' => 'toto', 'soft' => 'titi')));
    }

    /**
     * @Route("/edit/{visibility}/{soft}", name="files_edit")
     * @Method({"GET"})
     * @Template
     */
    public function editAction($visibility = '', $soft = '')
    {
        /* @var $uploader FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $uploadDir = $uploader->getFileBasePath();
    
        $form = $this->createFormBuilder()
                        ->add($soft,         'text',  array('label' => 'name'))
                        ->add($visibility,   'checkbox')
                        ->getForm();

        $fs = new Filesystem();
        do {
            // Build unique ID
            $key = sprintf('%09d', mt_rand(0, 1999999999));
        } while ($fs->exists($uploadDir . '/tmp/' . $key));

        // Create temporary directory where the user will be able to play with the files
        $tmp_dir = $uploadDir . '/tmp/' . $key;
        $fs->mkdir($tmp_dir);
        $tmp_dir .= '/originals';
        $fs->mkdir($tmp_dir);

        // mirror data_dir so that the user can edit current files
        $data_dir = $this->getDataDir($visibility, $soft);
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

        /* @var $form Form */
        $form = $this->createFormBuilder()->add('name')->add('public', 'checkbox')->getForm();

        $form->bind($this->getRequest());
        $soft = $form->get("name")->getData();
        $visibility = $form->get("public")->getData() ? 'public' : 'private';

        if ($form->isValid()) {
            $fs = new Filesystem();

            // Create data directory if soft is new 
            $data_dir = $this->getDataDir($visibility, $soft);
            if (!$fs->exists($data_dir)) {
                $fs->mkdir($data_dir);
            }
            $tmp_dir = $uploadDir . '/tmp/' . $key . '/originals';
            $fs->mirror($tmp_dir, $data_dir);
            $fs->remove($tmp_dir);
            $this->get('session')->getFlashBag()->add('notice', 'File upload as been completed!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'File upload could not be completed... Please check form values and retry');
        }
        return $this->redirect($this->generateUrl('files_edit', array('visibility' => $visibility, 'soft' => $soft)));
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
        //TODO Flashbag
        // $this->get('session')->getFlashBag()->add('notice', 'File upload as been cancelled!');

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
