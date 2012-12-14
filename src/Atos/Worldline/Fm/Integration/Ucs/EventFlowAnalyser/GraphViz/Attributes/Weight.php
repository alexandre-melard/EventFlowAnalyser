<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Weight of edge. In dot, the heavier the weight, the shorter,
 *   straighter and more vertical the edge is.
 *   <B>N.B.</b> Weights in dot must be integers.
 *   For other layouts, a larger weight encourages the layout to 
 *   make the edge length closer to that specified by the 
 *   <A HREF=#dlen>len</a> attribute.
 */
class Weight extends AbstractAttributes
{                
    
    protected $name = "weight";
}
