<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Logical head of an edge. When <A HREF=#dcompound><B>compound</b></a> is true,
 *   if <B>lhead</b> is defined and is the name of a cluster containing
 *   the real head,
 *   the edge is clipped to the boundary of the cluster.
 *   See <A HREF=#h:undir_note>limitation</a>.
 */
class Lhead extends AbstractAttributes
{                
    
    protected $name = "lhead";
}
