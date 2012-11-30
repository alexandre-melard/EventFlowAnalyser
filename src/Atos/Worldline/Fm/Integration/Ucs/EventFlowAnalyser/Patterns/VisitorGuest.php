<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns;

interface VisitorGuest
{
    public function visit(VisitorHost $host);
}
