<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If the input graph defines the <A HREF=#dvertices><B>vertices</b></a>
 *   attribute, and output is dot or xdot, this gives
 *   the number of points used for a node whose shape is a circle or ellipse.
 *   It plays the same role in neato, when adjusting the layout to avoid
 *   overlapping nodes, and in image maps.
 */
class Samplepoints extends AbstractAttributes
{                
    
    protected $name = "samplepoints";
}
