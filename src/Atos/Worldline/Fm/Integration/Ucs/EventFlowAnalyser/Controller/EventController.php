<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Symfony\Component\Finder\Finder;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventFlow;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\EventFlowService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\ProjectDao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\EventFlowDao;

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
        
        /* @var $project Project */
        $project = $projectDao->get($this->getUser(), $visibility, $name);
        
        return array(
            'title' => 'Display All Events',
            'visibility' => $visibility,
            'name' => $name,
            'events' => $project->getEvents()
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
        
        /* @var $project Project */
        $project = $projectDao->get($this->getUser(), $visibility, $name);

        /* @var $event Event */
        foreach ($project->getEvents() as $current) {
            if ( $current->getType() == $type ) {
                $event = $current;        
                break;        
            }
        }
        $in = array();
        $out = array();
        foreach ($project->getDocuments() as $document) {
            /* @var $document Document */
            foreach ($document->getParser()->getEventIns() as $eventIn) {
                /* @var $eventIn EventIn */
                if($eventIn->getEvent()->getType() == $type) {
                    $in[] = $document;
                }
                foreach ($eventIn->getEventOuts() as $eventOut) {
                    /* @var $eventOut EventOut */
                    if($eventOut->getEvent()->getType() == $type) {
                        $out[] = $document;
                    }
                }
            }
        }
//         $filesRes = $eventFlowService->files($parsers, $event);
        
        return array(
            'title' => $event->getShortEvent(),
            'visibility' => $visibility,
            'name' => $name,
            'event' => $type,
            'parents' => $event->getParents(),
            'children' => $event->getChildren(),
            'input' => $in,
            'output' => $out    
        );
    }
}
