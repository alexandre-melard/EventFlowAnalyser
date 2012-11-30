<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;

interface ParserServiceAware {
    public function setParserService(ParserService $parserService);
}