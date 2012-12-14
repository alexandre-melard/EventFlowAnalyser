<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Color used to draw the bounding box around a cluster.
 *   If <B>pencolor</b> is not defined, <A HREF=#dcolor><B>color</b></a> is
 *   used. If this is not defined, <A HREF=#dbgcolor>bgcolor</a> is used.
 *   If this is not defined, the default is used.
 *   <P>
 *   Note that a cluster inherits the root graph's attributes if defined.
 *   Thus, if the root graph has defined a <B>pencolor</b>, this will override a
 *   <B>color</b> or <B>bgcolor</b> attribute set for the cluster.
 */
class Pencolor extends AbstractAttributes
{                
    
    protected $name = "pencolor";
}
