<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If true, the head of an edge is clipped to the boundary of the head node;
 *   otherwise, the end of the edge goes to the center of the node, or the
 *   center of a port, if applicable.
 */
class Headclip extends AbstractAttributes
{                
    
    protected $name = "headclip";
}
