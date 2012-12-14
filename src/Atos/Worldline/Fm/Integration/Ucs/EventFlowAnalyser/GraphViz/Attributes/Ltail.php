<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Logical tail of an edge. When <A HREF=#dcompound><B>compound</b></a> is true,
 *   if <B>ltail</b> is defined and is the name of a cluster
 *   containing the real tail,
 *   the edge is clipped to the boundary of the cluster.
 *   See <A HREF=#h:undir_note>limitation</a>.
 */
class Ltail extends AbstractAttributes
{                
    
    protected $name = "ltail";
}
