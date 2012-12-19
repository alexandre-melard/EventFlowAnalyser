<?php
namespace Mylen\EventFlowAnalyser\Patterns;

interface VisitorHost
{
    public function accept(VisitorGuest $guest);    
}
