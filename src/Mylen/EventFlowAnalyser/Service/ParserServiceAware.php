<?php
namespace Mylen\EventFlowAnalyser\Service;

use Mylen\EventFlowAnalyser\Service\ParserService;

interface ParserServiceAware {
    public function setParserService(ParserService $parserService);
}