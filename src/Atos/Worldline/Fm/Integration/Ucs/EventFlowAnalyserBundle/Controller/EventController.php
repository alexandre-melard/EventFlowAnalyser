<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\EventFlow;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\EventFlowService;
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
     * @Route("/{use}/{soft}/all", name="events_all")
     * @Template
     */
    public function allAction($use, $soft)
    {
        $dir = $this->getUser()->getSalt();
        $path = $this->get('kernel')->locateResource("@UcsEventFlowAnalyserBundle/Resources/data/$dir/$use/$soft");
        $parsers = ParserService::parseDir($path);
        $events = EventFlowService::uniqueEvents($parsers);
        return array(
            'title' => 'Display All Events',
            'use' => $use,
            'soft' => $soft,
            'events' => $events
        );
    }

    /**
     * @Route("/event/{use}/{soft}/{id}", name="events_event")
     * @Template
     */
    public function eventAction($use, $soft, $id)
    {
        $logger = $this->get('logger');
        $dir = $this->getUser()->getSalt();
        $path = $this->get('kernel')->locateResource("@UcsEventFlowAnalyserBundle/Resources/data/$dir/$use/$soft");
        $parsers = ParserService::parseDir($path);

        $event = new Event($id);

        $parents = EventFlowService::parents($parsers, $event);
        $children = EventFlowService::children($parsers, $event);
        $eventFlow = new EventFlow($event, $parents, $children);
        $files = EventFlowService::files($parsers, $event);
        ;

        return array(
            'title' => EventFlowService::getShortEvent($event->type),
            'use' => $use,
            'soft' => $soft,
            'event' => $eventFlow->event->type,
            'parents' => $eventFlow->parents,
            'children' => $eventFlow->children,
            'files' => $files
        );
    }
}
