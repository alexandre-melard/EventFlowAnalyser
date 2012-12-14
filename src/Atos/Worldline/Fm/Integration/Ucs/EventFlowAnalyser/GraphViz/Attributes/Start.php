<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Parameter used to determine the initial layout of nodes. If unset, the
 *   nodes are randomly placed in a unit square with
 *   the same seed is always used for the random number generator, so the
 *   initial placement is repeatable.
 */
class Start extends AbstractAttributes
{                
    
    protected $name = "start";
}
