<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * ParserService class provides utility functions to work with parser xml files .
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\EventOut;

class ParserService
{
    /**
     * Parse xml file to return Parser array type.
     * events -> in -> event
     *              -> out -> event
     * @param Parser $parser
     * @return Parser
     */
    public static function parse(Parser $parser)
    {
        $xml = simplexml_load_file($parser->file);
        if (null != $xml->events->in) {
            foreach ($xml->events->in as $in) {
                if (null != $xml->events->in->children()) {
                    foreach ($in->children() as $inChild) {
                        if ($inChild->getName() === "event") {
                            $eventIn = new EventIn((string)$inChild);
                        } elseif ($inChild->getName() === "out") {
                            if (null != $inChild->children()) {
                                foreach ($inChild->children() as $outChild) {
                                    if ($outChild->getName() === "event") {
                                        $eventIn->addEventOut(new EventOut((string)$outChild));
                                    }
                                }
                            }
                            $parser->addEventIn($eventIn);
                        }
                    }
                }
            }
        }
        return $parser;
    }

    /**
     * @param $dir path to xml directory
     * @return Parser[]
     * @throws \RuntimeException
     */
    public static function parseDir($dir)
    {
        if (!is_dir($dir)) {
            throw new \RuntimeException("Directory does not exists: [" . $dir . "]");
        }
        /** @var $parsers Parser[] */
        $parsers = array();
        $files = scandir($dir);
        foreach ($files as $file) {
            if (substr($file, -3, 3) === "xml") {
                array_push($parsers, ParserService::parse(new Parser($dir.DIRECTORY_SEPARATOR.$file)));
            }
        }
        return $parsers;
    }
}
