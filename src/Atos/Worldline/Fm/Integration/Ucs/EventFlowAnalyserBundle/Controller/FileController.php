<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\Document;
use Symfony\Component\Config\Definition\Exception\Exception;

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
        $webDir = $this->get('kernel')->getRootDir() . '/../web';
        $posting = new Document($webDir);

        $form = $this->createFormBuilder($posting)
            ->add('name')
            ->add('file')
            ->getForm();

        $request = $this->getRequest();
        $editId = $request->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            $editId = sprintf('%09d', mt_rand(0, 1999999999));
            if ($posting->id) {
                $this->get('punk_ave.file_uploader')->syncFiles(
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
     * @Route("/upload", name="files_upload")
     * @Template()
     */
    public function uploadAction()
    {
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new \Exception("Bad edit id");
        }

        $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
    }

    /**
     *
     * @Route("/cancel", name="files_cancel")
     * @Template()
     */
    public function cancelAction()
    {
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new \Exception("Bad edit id");
        }
        try {
            $this->get('punk_ave.file_uploader')->removeFiles(array('folder' => 'tmp/attachments/' . $editId));
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
        $posting = $this->getRequest()->get('posting');

        try {
            $this->get('punk_ave.file_uploader')->removeFiles(array('folder' => 'attachments/' . $posting->getId()));
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
    public
    function allAction()
    {
        $dir = $this->getUser()->getSalt();
        $path = $this->get('kernel')->locateResource('@UcsEventFlowAnalyserBundle/Resources/data/' . $dir);
        $files = FileService::scanDir($path);
        return array(
            "title" => "Display All Files",
            "private" => $files['private'],
            "public" => $files['public']
        );
    }
}
