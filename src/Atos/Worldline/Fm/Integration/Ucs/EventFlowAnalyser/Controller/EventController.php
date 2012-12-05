<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\FileService;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\ProjectDao;

use Symfony\Component\Finder\Finder;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventFlow;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\EventFlowService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/events")
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="events_default")
     * @Template
     */
    public function indexAction()
    {
        return array(
            "title" => "Events",
        );
    }

    /**
     * @Route("/{visibility}/{name}/all", name="events_all")
     * @Template
     */
    public function allAction($visibility, $name)
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        $project = $projectDao->get($this->getUser(), $visibility, $name);
        $documents = $project->getDocuments();
        $parsers = array();
        foreach ($documents as $document) {
            /* @var $document Document */
            $parsers[] = $document->getParser();
        }
        
        $events = $this->get('app.event_flow')->uniqueEvents($name, $parsers);
        
        return array(
            'title' => 'Display All Events',
            'visibility' => $visibility,
            'name' => $name,
            'events' => $events
        );
    }

    /**
     * @Route("/event/{visibility}/{name}/{type}", name="events_event")
     * @Template
     */
    public function eventAction($visibility, $name, $type)
    {
        $logger = $this->get('logger');
        
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        $project = $projectDao->get($this->getUser(), $visibility, $name);
        $documents = $project->getDocuments();
        $parsers = array();
        foreach ($documents as $document) {
            /* @var $document Document */
            $parsers[] = $document->getParser();
        }
                
        $event = new Event($type);
        /* $eventFlowService EventFlowService */
        $eventFlowService = $this->get('app.event_flow');
        $parents = $eventFlowService->parents($parsers, $event);
        $children = $eventFlowService->children($parsers, $event);
        $eventFlow = new EventFlow($event, $parents, $children);
        $filesRes = $eventFlowService->files($parsers, $event);
        
        return array(
            'title' => $event->getShortEvent(),
            'visibility' => $visibility,
            'name' => $name,
            'event' => $eventFlow->getEvent()->getType(),
            'parents' => $eventFlow->getParents(),
            'children' => $eventFlow->getChildren(),
            'files' => $filesRes
        );
    }
}
