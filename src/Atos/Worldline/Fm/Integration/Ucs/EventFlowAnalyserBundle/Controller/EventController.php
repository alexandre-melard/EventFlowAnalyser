<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Controller;

use Atos\Worldline\Fm\UserBundle\Entity\User;
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
        /** @var $user User */
        $user = $this->getUser();
        $dir = $user->getSalt();
        $parsers = ParserService::parseDir(dirname(__FILE__) . "/../Resources/data/$dir/public/soft");
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
        /** @var $user User */
        $user = $this->getUser();
        $dir = $user->getSalt();
        $parsers = ParserService::parseDir(dirname(__FILE__) . "/../Resources/data/$dir/public/soft");
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
