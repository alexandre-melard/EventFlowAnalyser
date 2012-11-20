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

        $form = $this->createFormBuilder($posting)
            ->add('name')
            ->getForm();


        $request = $this->getRequest();
        $editId = $request->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            $editId = sprintf('%09d', mt_rand(0, 1999999999));

            if ($posting->id) {
                $uploader->syncFiles(
                    array('from_folder' => 'attachments/' . $posting->id,
                        'to_folder' => 'tmp/attachments/' . $editId,
                        'create_to_folder' => true));
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

        return array(
            'form' => $form->createView(),
            'editId' => $editId,
            'posting' => $posting,
            'isNew' => $isNew
        );
    }

    /**
     *
     * @Route("/upload/{editId}", name="files_upload")
     * @Method({"POST", "GET", "GET", "DELETE", "HEAD", "OPTIONS"})
     * @Template()
     */
    public function uploadAction($editId)
    {
        /** @var FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new \Exception("Bad edit id");
        }
        /** 
         * @var \Mylen\JQueryFileUploadBundle\Services\IResponseContainer 
         * */
        $res = $uploader->handleFileUpload('tmp/attachments/' . $editId);

        return new \Symfony\Component\HttpFoundation\Response($res->getBody(), $res->getType(), $res->getHeader());

    }

    /**
     *
     * @Route("/cancel", name="files_cancel")
     * @Template()
     */
    public function cancelAction()
    {
        /** @var FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new \Exception("Bad edit id");
        }

        try {
            $uploader->removeFiles(array('folder' => 'tmp/attachments/' . $editId));
            $this->get('session')->getFlashBag()->add('notice', 'File upload as been cancelled!');
        } catch (Exception $e) {
            $this->get('session')->getFlashBag()->add('error', 'could not remove file: system error: ' . $e);
        }
        return $this->redirect($this->generateUrl('default'));
    }

    /**
     *
     * @Route("/delete", name="files_delete")
     * @Template()
     */
    public function deleteAction()
    {
        /** @var FileUploader */
        $uploader = $this->get('mylen.file_uploader');
        $posting = $this->getRequest()->get('posting');

        try {
            $uploader->removeFiles(array('folder' => 'attachments/' . $posting->getId()));
            $this->get('session')->getFlashBag()->add('notice', 'File upload as been cancelled!');
        } catch (Exception $e) {
            $this->get('session')->getFlashBag()->add('error', 'could not remove file: system error: ' . $e);
        }
        return $this->redirect($this->generateUrl('default'));
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
        $files = FileService::scanDir($path);
        return array(
            "title" => "Display All Files",
            "private" => $files['private'],
            "public" => $files['public']
        );
    }
}
