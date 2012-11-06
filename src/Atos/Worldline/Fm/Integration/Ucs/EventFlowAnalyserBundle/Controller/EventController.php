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
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        return array(
            "title" => "Events",
        );
    }

    /**
     * @Route("/all")
     * @Template
     */
    public function allAction()
    {
        $dir = $this->getUser()->getSalt();
        $path = $this->get('kernel')->locateResource('@UcsEventFlowAnalyserBundle/Resources/data/' . $dir . 'public/soft');
        $parsers = ParserService::parseDir($path);
        $events = EventFlowService::uniqueEvents($parsers);
        return array(
            "title" => "Display All Events",
            "events" => $events
        );
    }

    /**
     * @Route("/event/{id}")
     * @Template
     */
    public function eventAction($id)
    {
        $dir = $this->getUser()->getSalt();
        $path = $this->get('kernel')->locateResource('@UcsEventFlowAnalyserBundle/Resources/data/' . $dir . 'public/soft');
        $parsers = ParserService::parseDir($path);

        $event = new Event($id);

        $parents = EventFlowService::parents($parsers, $event);
        $children = EventFlowService::children($parsers, $event);
        $eventFlow = new EventFlow($event, $parents, $children);

        return array(
            "title" => "Display Event",
            "event" => $eventFlow->event->type,
            "parents" => $eventFlow->parents,
            "children" => $eventFlow->children
        );
    }
}
