<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Edges with the same head and the same <B>samehead</b> value are aimed
 *   at the same point on the head. This has no effect on loops.
 *   Each node can have at most 5 unique samehead values.
 *   See <A HREF=#h:undir_note>limitation</a>.
 */
class Samehead extends AbstractAttributes
{                
    
    protected $name = "samehead";
}
