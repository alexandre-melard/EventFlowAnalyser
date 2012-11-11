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
        ParserService::validate($parser->file, $parser->xsd);

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
                array_push($parsers, ParserService::parse(new Parser($dir . DIRECTORY_SEPARATOR . $file, $dir . "/../../../../validation/xsd/eventflow.xsd")));
            }
        }
        return $parsers;
    }

    public static function libxml_display_error($error)
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

    public static function libxml_display_errors($display_errors = true)
    {
        $errors = libxml_get_errors();
        $chain_errors = "";

        foreach ($errors as $error) {
            $chain_errors .= preg_replace('/( in\ \/(.*))/', '', strip_tags(ParserService::libxml_display_error($error))) . "\n";
            if ($display_errors) {
                trigger_error(ParserService::libxml_display_error($error), E_USER_WARNING);
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
    public static function validate($file, $schema)
    {
        $result = false;
// Activer "user error handling"
        libxml_use_internal_errors(true);

// Instanciation d'un DOMDocument
        $dom = new \DOMDocument("1.0");

// Charge du XML depuis un fichier
        $dom->load($file);

// Validation du document XML
        $validate = $dom->schemaValidate($schema);

// Affichage du résultat
        if ($validate) {
            $result = true;
        } else {
            $error = ParserService::libxml_display_errors();
            libxml_use_internal_errors(false);
            throw new Exception("DOMDocument::schemaValidate() Generated Errors : $error");
        }
        libxml_use_internal_errors(false);
        return $result;
    }
}
