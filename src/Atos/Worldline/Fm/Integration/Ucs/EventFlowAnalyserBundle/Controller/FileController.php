<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/files")
 */
class FileController extends Controller
{
    /**
     * @Route("/", name="file_default")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/all", name="file_all")
     * @Template
     */
    public function allAction()
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


    /**
     * @Route("/edit", name="file_edit")
     * @Template
     */
    public function editAction()
    {
        $request = $this->getRequest();

        $editId = $request->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            $editId = sprintf('%09d', mt_rand(0, 1999999999));
            if ($request->request->get('Id')) {
                $this->get('punk_ave.file_uploader')->syncFiles(
                    array('from_folder' => 'attachments/' . $request->request->get('Id'),
                        'to_folder' => 'tmp/attachments/' . $editId,
                        'create_to_folder' => true));
            }
        }
    }
}
