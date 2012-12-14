<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If the input graph defines this attribute, the node is polygonal,
 *   and output is dot or xdot, this attribute provides the
 *   coordinates of the vertices of the node's polygon, in inches.
 *   If the node is an ellipse or circle, the
 *   <A HREF=#dsamplepoints>samplepoints</a> attribute affects
 *   the output.
 */
class Vertices extends AbstractAttributes
{                
    
    protected $name = "vertices";
}
