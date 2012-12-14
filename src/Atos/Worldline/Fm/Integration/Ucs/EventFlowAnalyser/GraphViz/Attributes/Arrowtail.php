<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\ArrowType;

/**
 * Style of arrowhead on the tail node of an edge.
 *   This will only appear if the <A HREF=#ddir>dir</a> attribute
 *   is "back" or "both".
 *   See the <A HREF=#h:undir_note>limitation</a>.
 */
class Arrowtail extends AbstractAttributes
{
    
    protected $name = "arrowtail";
    
    public function __construct(ArrowType $value)
    {
        parent::__construct($value);
    }
}
