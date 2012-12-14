<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\ArrowType;

/**
 * Style of arrowhead on the head node of an edge.
 *   This will only appear if the <A HREF=#ddir>dir</a> attribute
 *   is "forward" or "both".
 *   See the <A HREF=#h:undir_note>limitation</a>.
 */
class Arrowhead extends AbstractAttributes
{
    protected $name = "arrowhead";

    public function __construct(ArrowType $value)
    {
        parent::__construct($value);
    }    
}
