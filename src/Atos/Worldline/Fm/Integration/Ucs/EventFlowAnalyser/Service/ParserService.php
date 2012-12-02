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

    protected $xsd;

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
    public function __construct(Cache $c, Logger $l, $x)
    {
        parent::__construct($c);
        $this->logger = $l;
        $this->xsd = $x;
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
        } catch ( \ErrorException $e ) {
            try {
                $event = $this->eventDao->getByType($project, $type);
            } catch (NoResultException $e) {
                $event = new Event($type);
                $event->setProject($project);
            }
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
/**
 * TODO Add EventFlow loading, remove DB access !! As it is initial loading, 
 * DB should be empty for this project !!
 */
        
        $this->validate($parser->getDocument()->getPath(), $parser->getXsd());
        $xml = simplexml_load_file($parser->getDocument()->getPath());
        if (null != $xml->events->in) {
            foreach ($xml->events->in as $in) {
                $event = $this->getEvent($parser->getDocument()->getProject(), (string) $in->event);
                try {
                    $eventIn = $this->eventInDao->get($parser, $event);
                } catch (NoResultException $e) {
                    $eventIn = new EventIn();
                    $eventIn->setEvent($event);
                    $eventIn->setParser($parser);
                }
                if (null !== $in->out->event) {
                    foreach ($in->out->event as $eventType) {
                        $event = $this->getEvent($parser->getDocument()->getProject(), (string) $eventType);
                        try {
                            $eventOut = $this->eventOutDao->get($eventIn, $event);
                        } catch (NoResultException $e) {
                            $eventOut = new EventOut();
                            $eventOut->setEvent($event);
                            $eventOut->setEventIn($eventIn);
                        }
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
            try {
                $parser = $this->parserDao->get($document);
            } catch (NoResultException $e) {
                $parser = new Parser($document);
                $parser->setXsd($this->xsd);
                $parser->setDocument($document);
            }
            $document->setParser($this->parse($parser));
        }

        return $documents;
    }

    /**
     * @param    array $files path to xml directory
     * @return   array Parser
     * @throws \RuntimeException
     */
    public function parseFiles($files)
    {
        /** @var $parsers Parser[] */
        $parsers = array();
        foreach ($files as $file) {
            array_push($parsers, $this->parse(new Parser($file, $this->xsd)));
        }

        return $parsers;
    }

    public function libxmlDisplayError($error)
    {
        $return = "\n";
        switch ($error->level) {
        case LIBXML_ERR_WARNING:
            $return .= "Warning $error->code: ";
            break;
        case LIBXML_ERR_ERROR:
            $return .= "Error $error->code: ";
            break;
        case LIBXML_ERR_FATAL:
            $return .= "Fatal Error $error->code: ";
            break;
        }
        $return .= trim($error->message);
        if ($error->file) {
            $return .= " in $error->file";
        }
        $return .= " on line $error->line\n";

        return $return;
    }

    public function libxmlDisplayErrors($display_errors = true)
    {
        $errors = libxml_get_errors();
        $chain_errors = "";

        foreach ($errors as $error) {
            $chain_errors .= preg_replace('/( in\ \/(.*))/', '', strip_tags($this->libxmlDisplayError($error))) . "\n";
            if ($display_errors) {
                trigger_error($this->libxmlDisplayError($error), E_USER_WARNING);
            }
        }
        libxml_clear_errors();

        return $chain_errors;
    }

    /** Validate xml file regarding xsd
     * @param $file
     * @param $schema
     * @return bool
     * @throws Exception
     */
    public function validate($file, $schema)
    {
        $result = false;
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument("1.0");
        $dom->load($file);
        $validate = $dom->schemaValidate($schema);
        if ($validate) {
            $result = true;
        } else {
            $error = $this->libxmlDisplayErrors();
            libxml_use_internal_errors(false);
            throw new Exception("DOMDocument::schemaValidate() Generated Errors : $error");
        }
        libxml_use_internal_errors(false);

        return $result;
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
