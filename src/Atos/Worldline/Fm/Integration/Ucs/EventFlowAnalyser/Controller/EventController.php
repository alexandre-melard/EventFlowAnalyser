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
     * @Route("/{visibility}/{soft}/all", name="events_all")
     * @Template
     */
    public function allAction($visibility, $soft)
    {
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        $project = $projectDao->get($this->getUser(), $visibility, $soft);
        $documents = $project->getDocuments();
        $parsers = array();
        foreach ($documents as $document) {
            /* @var $document Document */
            $parsers[] = $document->getParser();
        }
        
        $events = $this->get('app.event_flow')->uniqueEvents($soft, $parsers);
        
        return array(
            'title' => 'Display All Events',
            'visibility' => $visibility,
            'soft' => $soft,
            'events' => $events
        );
    }

    /**
     * @Route("/event/{visibility}/{soft}/{id}", name="events_event")
     * @Template
     */
    public function eventAction($visibility, $soft, $id)
    {
        $logger = $this->get('logger');
        
        /* @var $projectDao ProjectDao */
        $projectDao = $this->get('app.project_dao');
        $project = $projectDao->get($this->getUser(), $visibility, $soft);
        $documents = $project->getDocuments();
        $parsers = array();
        foreach ($documents as $document) {
            /* @var $document Document */
            $parsers[] = $document->getParser();
        }
                
        $event = new Event($id);
        $eventFlowService = $this->get('app.event_flow');
        $parents = $eventFlowService->parents($parsers, $event);
        $children = $eventFlowService->children($parsers, $event);
        $eventFlow = new EventFlow($event, $parents, $children);
        $filesRes = $eventFlowService->files($parsers, $event);
        
        return array(
            'title' => $eventFlowService->getShortEvent($event->getType()),
            'visibility' => $visibility,
            'soft' => $soft,
            'event' => $eventFlow->getEvent()->getType(),
            'parents' => $eventFlow->getParents(),
            'children' => $eventFlow->getChildren(),
            'files' => $filesRes
        );
    }
}
