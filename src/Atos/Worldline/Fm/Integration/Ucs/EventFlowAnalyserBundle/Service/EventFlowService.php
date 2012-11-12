<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 20:37
 * To change this template use File | Settings | File Templates.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\EventOut;

class EventFlowService
{
    /**
     * @param $parsers Parser[]
     * @param $event Event
     * @return Event[]
     */
    public static function parents($parsers, $event)
    {
        $parents = array();
        foreach ($parsers as $parser) {
            foreach ($parser->eventIns as $eventIn) {
                foreach ($eventIn->eventOuts as $eventOut) {
                    if ($eventOut->type === $event->type) {
                        array_push($parents, ["event" => $eventIn, "file" => basename($parser->file, '.xml')]);
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
    public static function children($parsers, $event)
    {
        $children = array();
        foreach ($parsers as $parser) {
            foreach ($parser->eventIns as $eventIn) {
                if ($eventIn->type === $event->type) {
                    foreach ($eventIn->eventOuts as $eventOut) {
                        array_push($children, ["event" => $eventOut, "file" => basename($parser->file, '.xml')]);
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
    public static function files($parsers, $event)
    {
        $files = array();
        foreach ($parsers as $parser) {
            foreach ($parser->eventIns as $eventIn) {
                if ($eventIn->type === $event->type) {
                    array_push($files, ["direction" => "in", "name" => basename($parser->file, '.xml')]);
                }
                foreach ($eventIn->eventOuts as $eventOut) {
                    if ($eventOut->type === $event->type) {
                        array_push($files, ["direction" => "out", "name" => basename($parser->file, '.xml')]);
                    }
                }
            }
        }
        return $files;
    }

    /**
     * @param $parsers Parser[]
     * @return Event[]
     */
    public static function uniqueEvents($parsers)
    {
        $events = array();
        foreach ($parsers as $parser) {
            foreach ($parser->eventIns as $eventIn) {
                foreach ($eventIn->eventOuts as $eventOut) {
                    array_push($events, $eventOut->type);
                }
                array_push($events, $eventIn->type);
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
    public static function eventParsers($parsers, $event)
    {
        /** @var $resParsers Parser[] */
        $resParsers = array();
        foreach ($parsers as $parser) {
            foreach ($parser->eventIns as $eventIn) {
                foreach ($eventIn->eventOuts as $eventOut) {
                    if ($eventOut->type == $event->type) {
                        array_push($resParsers, ["file" => basename($parser->file, '.xml'), "type" => $eventOut->type, "direction" => "out"]);
                    }
                }
                if ($eventIn->type == $event->type) {
                    array_push($resParsers, ["file" => basename($parser->file, '.xml'), "type" => $eventIn->type, "direction" => "in"]);
                }
            }
        }
        return $resParsers;
    }

    public static function getShortEvent($event)
    {
        return str_replace("CORE_MSG_TYPE_", "", $event);
    }

}
