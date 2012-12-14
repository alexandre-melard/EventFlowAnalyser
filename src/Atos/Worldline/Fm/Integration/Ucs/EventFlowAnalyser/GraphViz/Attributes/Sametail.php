<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Edges with the same tail and the same <B>sametail</b> value are aimed
 *   at the same point on the tail. This has no effect on loops.
 *   Each node can have at most 5 unique sametail values.
 *   See <A HREF=#h:undir_note>limitation</a>.
 */
class Sametail extends AbstractAttributes
{                
    
    protected $name = "sametail";
}
