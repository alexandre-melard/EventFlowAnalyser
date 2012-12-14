<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This, along with <A HREF=#dlabeldistance>labeldistance</a>, determine
 *   where the
 *   headlabel (taillabel) are placed with respect to the head (tail)
 *   in polar coordinates. The origin in the coordinate system is
 *   the point where the edge touches the node. The ray of 0 degrees
 *   goes from the origin back along the edge, parallel to the edge
 *   at the origin.
 *   <P>
 *   The angle, in degrees, specifies the rotation from the 0 degree ray,
 *   with positive angles moving counterclockwise and negative angles
 *   moving clockwise.
 */
class Labelangle extends AbstractAttributes
{                
    
    protected $name = "labelangle";
}
