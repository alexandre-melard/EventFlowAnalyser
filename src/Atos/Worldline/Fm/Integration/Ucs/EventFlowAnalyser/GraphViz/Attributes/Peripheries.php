<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Set number of peripheries used in polygonal shapes and cluster
 *   boundaries. Note that
 *   <A HREF=node-shapes#epsf>user-defined shapes</a> are treated as a
 *   form of box shape, so the default
 *   peripheries value is 1 and the user-defined shape will be drawn in
 *   a bounding rectangle. Setting <TT>peripheries=0</tt> will turn this off.
 *   Also, 1 is the maximum peripheries value for clusters.
 */
class Peripheries extends AbstractAttributes
{                
    
    protected $name = "peripheries";
}
