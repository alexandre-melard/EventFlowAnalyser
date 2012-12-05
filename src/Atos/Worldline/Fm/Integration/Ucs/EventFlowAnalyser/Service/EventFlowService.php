<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 20:37
 * To change this template use File | Settings | File Templates.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Monolog\Logger;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\DependencyInjection\CacheAware;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;

class EventFlowService extends CacheAware
{
    /* @var $logger Logger */
    protected $logger;
    
    /**
     * @param Cache $c
     */
    public function __construct($c, $l)
    {
        parent::__construct($c);
        $this->logger = $l;
    }
    
    /**
     * @param $parsers Parser[]
     * @param $event Event
     * @return Event[]
     */
    public function parents($parsers, $event)
    {
        $parents = array();
        foreach ($parsers as $parser) {
            /* @var $parser Parser */
            foreach ($parser->getEventIns() as $eventIn) {
                /* @var $eventIn EventIn */
                foreach ($eventIn->getEventOuts() as $eventOut) {
                    /* @var $eventOut EventOut */
                    if ($eventOut->getType() === $event->getType()) {
                        array_push($parents, array("event" => $eventIn, "file" => basename($parser->getDocument()->getPath(), '.xml')));
                    }
                }
            }
        }

        return $parents;
    }

    /**
     * @param $parsers Parser[]
     * @param $event Event
     * @return Event[]
     */
    public function children($parsers, $event)
    {
        $children = array();
        foreach ($parsers as $parser) {
            /* @var $parser Parser */
            foreach ($parser->getEventIns() as $eventIn) {
                /* @var $eventIn EventIn */
                if ($eventIn->getType() === $event->getType()) {
                    foreach ($eventIn->getEventOuts() as $eventOut) {
                        /* @var $eventOut EventOut */
                        array_push($children, array("event" => $eventOut, "file" => basename($parser->getDocument()->getPath(), '.xml')));
                    }
                }
            }
        }
        
        return $children;
    }

    /**
     * @param $parsers Parser[]
     * @param $event Event
     * @return array
     */
    public function files($parsers, $event)
    {
        $files = array();
        foreach ($parsers as $parser) {
            /* @var $parser Parser */
            foreach ($parser->getEventIns() as $eventIn) {
                /* @var $eventIn EventIn */
                if ($eventIn->getType() === $event->getType()) {
                    array_push($files, array("direction" => "input", "document" => $parser->getDocument()));
                }
                foreach ($eventIn->getEventOuts() as $eventOut) {
                    /* @var $eventOut EventOut */
                    if ($eventOut->getType() === $event->getType()) {
                        array_push($files, array("direction" => "output", "document" => $parser->getDocument()));
                    }
                }
            }
        }
        
        return $files;
    }

    /**
     * @param $soft
     * @param $parsers Parser[]
     * @return Event[]
     * @return array|mixed
     */
    public function uniqueEvents($soft, $parsers)
    {
        $events = array();
        foreach ($parsers as $parser) {
            /* @var $parser Parser */
            foreach ($parser->getEventIns() as $eventIn) {
                /* @var $eventIn EventIn */
                foreach ($eventIn->getEventOuts() as $eventOut) {
                    array_push($events, $eventOut->getType());
                }
                array_push($events, $eventIn->getType());
            }
        }
        $events = array_unique($events);
        asort($events);

        return $events;
    }

    /**
     * @param $parsers Parser[]
     * @param $event Event
     * @return Parser[]
     */
    public function eventParsers($parsers, $event)
    {
        /* @var $resParsers Parser[] */
        $resParsers = array();
        foreach ($parsers as $parser) {
            /* @var $parser Parser */
            foreach ($parser->getEventIns() as $eventIn) {
                /* @var $eventIn EventIn */
                foreach ($eventIn->getEventOuts() as $eventOut) {
                    /* @var $eventOut EventOut */
                    if ($eventOut->getType() == $event->getType()) {
                        array_push($resParsers, array("file" => basename($parser->getDocument()->getPath(), '.xml'), "type" => $eventOut->getType(), "direction" => "out"));
                    }
                }
                if ($eventIn->getType() == $event->getType()) {
                    array_push($resParsers, array("file" => basename($parser->getDocument()->getPath(), '.xml'), "type" => $eventIn->getType(), "direction" => "in"));
                }
            }
        }

        return $resParsers;
    }
}
