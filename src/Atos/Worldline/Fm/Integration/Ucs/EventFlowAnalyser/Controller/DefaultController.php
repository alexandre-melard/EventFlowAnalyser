<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\EventDao;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\EventInDao;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     * @Template
     */
    public function indexAction()
    {
        return array(
            "title" => "Welcome",
        );
    }
}
