<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Controller;

use Atos\Worldline\Fm\UserBundle\Entity\User;
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
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/all")
     * @Template
     */
    public function allAction()
    {
        /** @var $user User */
        $user = $this->getUser();
        $dir = $user->getSalt();
        $files = FileService::scanDir(dirname(__FILE__) . "/../Resources/data/$dir");
        return array(
            "title" => "Display All Files",
            "private" => $files['private'],
            "public" => $files['public']
        );
    }
}
