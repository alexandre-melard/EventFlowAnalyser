<?php
namespace Mylen\EventFlowAnalyser\Patterns;

interface VisitorGuest
{
    public function visit(VisitorHost $host);
}
