<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * The pad attribute specifies how much, in inches, to extend the
 *   drawing area around the minimal area needed to draw the graph.
 *   If the pad is a single double, both the x and y pad values are set
 *   equal to the given value. This area is part of the
 *   drawing and will be filled with the background color, if appropriate.
 *   <P>
 *   Normally, a small pad is used for aesthetic reasons, especially when
 *   a background color is used, to avoid having nodes and edges abutting
 *   the boundary of the drawn region.
 */
class Pad extends AbstractAttributes
{                
    
    protected $name = "pad";
}
