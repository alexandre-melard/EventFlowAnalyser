<?php
namespace Mylen\EventFlowAnalyser\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     * @Template
     */
    public function indexAction()
    {
        /* @var $eventService EventService */
        $eventService = $this->get('app.event');
        
        /* @var $project \Mylen\EventFlowAnalyser\Entity\Project */
        $project = $eventService->getProject($this->getUser(), 'ucs2');
        
        $graph = $project->getWebPath() . '/graphs/CORE_MSG_TYPE_RequestForTradeCreation.png';
        if (!$graph) {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') Event: CORE_MSG_TYPE_RequestForTradeCreation.png has not been generated yet... Please check again later.');
        }
        return array(
            'title' => 'Welcome',
            'graph' => $graph,
        );
    }
}
