<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Indicates where on the head node to attach the head of the edge.
 *   In the default case, the edge is aimed towards the center of the node,
 *   and then clipped at the node boundary.
 *   See <A HREF=#h:undir_note>limitation</a>.
 */
class Headport extends AbstractAttributes
{                
    
    protected $name = "headport";
}
