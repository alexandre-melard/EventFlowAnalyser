<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

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
     * @Route("/{use}/{soft}/all", name="events_all")
     * @Template
     */
    public function allAction($use, $soft)
    {
        $dir = $this->getUser()->getSalt();
        $path = $this->get('kernel')->locateResource("@UcsEventFlowAnalyser/Resources/data/$dir/$use/$soft");
        $parsers = (new ParserService($this->get('cache')))->parseDir($path);
        $events = (new EventFlowService($this->get('cache')))->uniqueEvents($soft, $parsers);
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
        $path = $this->get('kernel')->locateResource("@UcsEventFlowAnalyser/Resources/data/$dir/$use/$soft");
        $parsers = (new ParserService($this->get('cache')))->parseDir($path);

        $event = new Event($id);
        $eventFlowService = new EventFlowService($this->get('cache'));
        $parents = $eventFlowService->parents($parsers, $event);
        $children = $eventFlowService->children($parsers, $event);
        $eventFlow = new EventFlow($event, $parents, $children);
        $files = $eventFlowService->files($parsers, $event);
        ;

        return array(
            'title' => $eventFlowService->getShortEvent($event->type),
            'use' => $use,
            'soft' => $soft,
            'event' => $eventFlow->event->type,
            'parents' => $eventFlow->parents,
            'children' => $eventFlow->children,
            'files' => $files
        );
    }
}