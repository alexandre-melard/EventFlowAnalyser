<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * For graphs, this sets x and y margins of canvas, in inches. If the margin
 *   is a single double, both margins are set equal to the given value.
 *   <P>
 *   Note that the margin is not part of the drawing but just empty space
 *   left around the drawing. It basically corresponds to a translation of
 *   drawing, as would be necessary to center a drawing on a page. Nothing
 *   is actually drawn in the margin. To actually extend the background of
 *   a drawing, see the <A HREF=#dpad>pad</a> attribute.
 *   </p><P>
 *   For clusters, this specifies the space between the nodes in the cluster and
 *   the cluster bounding box. By default, this is 8 points.
 *   </p><P>
 *   For nodes, this attribute specifies space left around the node's label.
 *   By default, the value is <TT>0.11,0.055</tt>.
 */
class Margin extends AbstractAttributes
{                
    
    protected $name = "margin";
}
