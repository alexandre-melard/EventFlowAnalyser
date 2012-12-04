<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns;

interface VisitorHost
{
    public function accept(VisitorGuest $guest);    
}
