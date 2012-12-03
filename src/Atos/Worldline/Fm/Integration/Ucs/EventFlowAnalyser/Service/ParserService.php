<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * ParserService class provides utility functions to work with parser xml files .
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\ParserDao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\EventOutDao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\EventInDao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\EventDao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\DependencyInjection\CacheAware;

use Doctrine\Common\Cache\ApcCache;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Monolog\Logger;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\NoResultException;

class ParserService extends CacheAware
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var ParserDao
     */
    protected $parserDao;

    /**
     * @var EventDao
     */
    protected $eventDao;

    /**
     * @var EventInDao
     */
    protected $eventInDao;

    /**
     * @var EventOutDao
     */
    protected $eventOutDao;
    
   
    /**
     * 
     * @param Cache $c
     * @param Logger $l
     * @param string $x
     */
    public function __construct(Cache $c, Logger $l)
    {
        parent::__construct($c);
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
            $event = $project->getEvent($type);
<<<<<<< HEAD
            $this->logger->debug(__FUNCTION__ . ": found event :" . $event->getType());
        } catch ( \Exception $e ) {
            $this->logger->debug(__FUNCTION__ . ": caught exception :" . $e->getMessage());
            $event = new Event($type);
            $event->setProject($project);
            $project->addEvent($event);
            $this->logger->debug(__FUNCTION__ . ": creating event :" . $event->getType());
=======
        } catch ( \ErrorException $e ) {
            try {
                $event = $this->eventDao->getByType($project, $type);
            } catch (NoResultException $e) {
                $event = new Event($type);
                $event->setProject($project);
            }
            $project->addEvent($event);
>>>>>>> branch 'master' of https://github.com/mylen/EventFlowAnalyser.git
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
<<<<<<< HEAD
        $this->logger->debug("parse : " . $parser->getDocument()->getName());
=======
/**
 * TODO Add EventFlow loading, remove DB access !! As it is initial loading, 
 * DB should be empty for this project !!
 */
        
        $this->validate($parser->getDocument()->getPath(), $parser->getXsd());
>>>>>>> branch 'master' of https://github.com/mylen/EventFlowAnalyser.git
        $xml = simplexml_load_file($parser->getDocument()->getPath());
        $this->logger->debug("parse : set parser's document name to :" . $xml->header->process);
        $parser->getDocument()->setName($xml->header->process);
        if (null != $xml->events->in) {
            foreach ($xml->events->in as $in) {
                $event = $this->getEvent($parser->getDocument()->getProject(), (string) $in->event);
<<<<<<< HEAD
                $eventIn = new EventIn();
                $eventIn->setEvent($event);
                $eventIn->setParser($parser);
                $this->logger->debug(__FUNCTION__ . ": creating eventIn :" . $eventIn->getType());
=======
                try {
                    $eventIn = $this->eventInDao->get($parser, $event);
                } catch (NoResultException $e) {
                    $eventIn = new EventIn();
                    $eventIn->setEvent($event);
                    $eventIn->setParser($parser);
                }
>>>>>>> branch 'master' of https://github.com/mylen/EventFlowAnalyser.git
                if (null !== $in->out->event) {
                    foreach ($in->out->event as $eventType) {
                        $event = $this->getEvent($parser->getDocument()->getProject(), (string) $eventType);
                        $eventOut = new EventOut();
                        $eventOut->setEvent($event);
                        $eventOut->setEventIn($eventIn);
                        $this->logger->debug(__FUNCTION__ . ": creating eventOut :" . $eventOut->getType());
                        $eventIn->addEventOut($eventOut);
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

    /**
     * 
     * @param EventDao $dao
     */
    public function setEventDao(EventDao $dao)
    {
        $this->eventDao = $dao;
    }

    /**
     * 
     * @param EventInDao $dao
     */
    public function setEventInDao(EventInDao $dao)
    {
        $this->eventInDao = $dao;
    }

    /**
     * 
     * @param EventOutDao $dao
     */
    public function setEventOutDao(EventOutDao $dao)
    {
        $this->eventOutDao = $dao;
    }

    /**
     * 
     * @param ParserDao $parserDao
     */
    public function setParserDao(ParserDao $parserDao)
    {
        $this->parserDao = $parserDao;
    }

}
