<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * ParserService class provides utility functions to work with parser xml files .
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Monolog\Logger;

class ParserService
{
    /**
     * @var Logger
     */
    protected $logger;
   
    /**
     * 
     * @param Logger $l
     * @param string $x
     */
    public function __construct(Logger $l)
    {
        $this->logger = $l;
        $this->events = array();
    }
    
    /**
     * Create an event if not exists in cache.
     * This assure uniqueness of the event before flushing data to datasource.
     * @param string $type
     * @return Event
     */
    protected function getEvent(Project $project, $type) {
        try {
            $events = $project->getEvents();
            $event = $events[$type];
        } catch ( \Exception $e ) {
            $event = new Event($type);
            $event->setProject($project);
            $project->addEvent($event);
        }
        return $event;
    }
    
    /**
     * Parse xml file to return Parser array type.
     * events -> in -> event
     *              -> out -> event
     * @param Parser $parser
     * @return Parser
     */
    public function parse(Parser $parser)
    {
        $xml = simplexml_load_file($parser->getDocument()->getPath());
        $parser->getDocument()->setName($xml->header->process);
        if (null != $xml->events->in) {
            foreach ($xml->events->in as $in) {
                $eventInEvent = $this->getEvent($parser->getDocument()->getProject(), (string) $in->event);
                $eventIn = new EventIn();
                $eventIn->setEvent($eventInEvent);
                $eventIn->setParser($parser);
                if (null !== $in->out->event) {
                    foreach ($in->out->event as $eventType) {
                        $eventOutEvent = $this->getEvent($parser->getDocument()->getProject(), (string) $eventType);
                        $eventOut = new EventOut();
                        $eventOut->setEvent($eventOutEvent);
                        $eventOut->setEventIn($eventIn);
                        $eventIn->addEventOut($eventOut);
                        $eventInEvent->addChild($eventOut);
                        $eventOutEvent->addParent($eventIn);
                    }
                }
                $parser->addEventIn($eventIn);
            }
        }

        return $parser;
    }

    /**
     * @param    array Document
     * @return   array Document
     * @throws \RuntimeException
     */
    public function parseDocuments(array $documents)
    {
        /** @var $parsers Parser[] */
        $parsers = array();
        foreach ($documents as $document) {
            /* @var $document Document */

            /* @var $parser Parser */
            $parser = new Parser($document);
            $parser->setDocument($document);
            $document->setParser($this->parse($parser));
        }

        return $documents;
    }

}
