<?php

namespace Mylen\EventFlowAnalyser\Controller;

use Symfony\Component\HttpFoundation\Response;

use Mylen\EventFlowAnalyser\Service\GraphVizService;

use Mylen\EventFlowAnalyser\Entity\Project;
use Mylen\EventFlowAnalyser\Entity\Event;
use Mylen\EventFlowAnalyser\Service\EventService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/events")
 *
 */
class EventController extends Controller
{
    /**
     * @Route("/{projectName}", name="events_default")
     * @Template
     */
    public function indexAction($projectName)
    {
        /* @var $eventService EventService */
        $eventService = $this->get('app.event');
        
        /* @var $project Project */
        $project = $eventService->getProject($this->getUser(), $projectName);
        
        return array(
            "title" => "Events related to " . $project->getName()
        );
    }
    
    /**
     * @Route("/{projectName}/all", name="events_all")
     * @Template
     */
    public function allAction($projectName)
    {
        /* @var $eventService EventService */
        $eventService = $this->get('app.event');
                
        /* @var $project Project */
        $project = $eventService->getProject($this->getUser(), $projectName);
                
        $graph = $project->getWebPath() . '/graphs/' . $project->getName() . '.png';
        if (!$graph) {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') has not been generated yet... Please check again later.');
        }

        return array(
            'title' => 'Display All Events',
            'project' => $project,
            'events' => $project->getEvents(),
            'graph' => $graph    
        );
    }

    /**
     * @Route("/{projectName}/graph/{name}", name="events_graph")
     * @Template
     */
    public function graphAction($projectName, $name)
    {
        /* @var $eventService EventService */
        $eventService = $this->get('app.event');
    
        /* @var $project Project */
        $project = $eventService->getProject($this->getUser(), $projectName);
    
        /* @var $graphVizService GraphVizService */
        $graphVizService = $this->get('app.graph');
        $graph = $graphVizService->getGraph($project, $name);
    
        return array(
                'graph' => $graph
        );
    }

    /**
     * @Route("/event/{projectName}/{type}", name="events_event")
     * @Template
     */
    public function eventAction($projectName, $type)
    {
        $logger = $this->get('logger');
        
        /* @var $eventService EventService */
        $eventService = $this->get('app.event');
        
        /* @var $project Project */
        $project = $eventService->getProject($this->getUser(), $projectName);
        
        /* @var $event Event */
        $event = $eventService->getEventByType($project, $type);

        list($in, $out) = $eventService->getDocumentsByEvent($event); 
        
                
        $graph = $project->getWebPath() . '/graphs/' . $event->getType() . '.png';
        if (!$graph) {
            $this->get('session')->getFlashBag()->add('error', 'Project ' . $project->getName() . ' (' . $project->getVisibility() . ') '. $event->getType() .'has not been generated yet... Please check again later.');
        }
        return array(
            'title' => $event->getShortEvent(),
            'visibility' => $project->getVisibility(),
            'name' => $project->getName(),
            'event' => $event,
            'input' => $in,
            'output' => $out,
            'graph' => $graph        
        );
    }
}
