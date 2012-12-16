<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\GraphVizService;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\EventService;

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
                
        /* @var $graphVizService GraphVizService */
        $graphVizService = $this->get('app.graph');
        $graph = $graphVizService->generateProjectGraph($project);
        
        return array(
            'title' => 'Display All Events',
            'name' => $project->getName(),
            'events' => $project->getEvents(),
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
        
        /* @var $graphVizService GraphVizService */
        $graphVizService = $this->get('app.graph');
        $graphEvent = $graphVizService->generateEventGraph($event);
        $graphProcess = $graphVizService->generateProcessGraph($event);
        
        return array(
            'title' => $event->getShortEvent(),
            'visibility' => $project->getVisibility(),
            'name' => $project->getName(),
            'event' => $event,
            'input' => $in,
            'output' => $out,
            'graphEvent' => $graphEvent,
            'graphProcess' => $graphProcess        
        );
    }
}
