<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

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

    /**
     * @Route("/edit", name="files_edit")
     * @Template
     */
    public function editAction()
    {
        /** @var FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $webDir = $this->get('kernel')->getRootDir() . '/../web';
        $posting = new Document($webDir);

        $form = $this->createFormBuilder($posting)->add('name')->getForm();

        $request = $this->getRequest();
        $editId = $request->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            $editId = sprintf('%09d', mt_rand(0, 1999999999));

            if ($posting->id) {
                $uploader
                        ->syncFiles(
                                array('from_folder' => 'attachments/' . $posting->id, 'to_folder' => 'tmp/attachments/' . $editId, 'create_to_folder' => true));
            } else {
                $isNew = TRUE;
                $posting->id = 10;
            }
        }

        //        if ($this->getRequest()->isMethod('POST')) {
        //            $form->bind($this->getRequest());
        //            if ($form->isValid()) {
        //                $em = $this->getDoctrine()->getManager();
        //
        //                $em->persist($posting);
        //                $em->flush();
        //
        //                $this->redirect($this->generateUrl('files_uploaded'));
        //            }
        //        }

        return array('form' => $form->createView(), 'editId' => $editId, 'posting' => $posting, 'isNew' => $isNew);
    }

    /**
     * 
     * @param string $editId
     * @throws \Exception
     * @return \Mylen\JQueryFileUploadBundle\Services\IResponseContainer
     */
    protected function handleRequest($editId)
    {
        /** @var FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new \Exception("Bad edit id");
        }
        //TODO Flashbag
        // $this->get('session')->getFlashBag()->add('notice', 'File upload as been cancelled!');
        
        return $uploader->handleFileUpload('tmp/attachments/' . $editId);
    }
    
    /**
     *
     * @Route("/upload/{editId}", name="files_put")
     * @Method({"PATCH", "POST", "PUT"})
     */
    public function putAction($editId)
    {
        $upload = $this->handleRequest($editId);
        $upload->post();
        return new Response($upload->getBody(), $upload->getType(), $upload->getHeader());
    }
    
    /**
     *
     * @Route("/upload/{editId}", name="files_head")
     * @Method("HEAD")
     */
    public function headAction($editId)
    {
        $uploader = $this->handleRequest($editId);
        $uploader->head();
        return new Response($uploader->getBody(), $uploader->getType(), $uploader->getHeader());
    }

    /**
     *
     * @Route("/upload/{editId}", name="files_get")
     * @Method("GET")
     */
    public function getAction($editId)
    {
        $upload = $this->handleRequest($editId);
        $upload->get();
        return new Response($upload->getBody(), $upload->getType(), $upload->getHeader());
    }

    /**
     *
     * @Route("/upload/{editId}", name="files_delete")
     * @Method("DELETE")
     */
    public function deleteAction($editId)
    {
        $upload = $this->handleRequest($editId);
        $upload->delete();
        return new Response($upload->getBody(), $upload->getType(), $upload->getHeader());
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
