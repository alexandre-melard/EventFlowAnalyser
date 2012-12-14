<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If true, force polygon to be regular, i.e., the vertices of the
 *   polygon will lie on a circle whose center is the center of the node.
 */
class Regular extends AbstractAttributes
{                
    
    protected $name = "regular";
}
