<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\AttributeType;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\AddDoubleType;

/**
 * Specifies margin to leave around nodes when removing node overlap.
 *   This guarantees a minimal non-zero distance between nodes.
 *   <P>
 *   If the attribute begins with a plus sign '+', an additive margin is
 *   specified. That is, "+w,h" causes the node's bounding box to be increased 
 *   by w
 *   points on the left and right sides, and by h points on the top and bottom.
 *   Without a plus sign, the node is scaled by 1 + w in the x coordinate
 *   and 1 + h in the y coordinate.
 *   </p><P>
 *   If only a single number is given, this is used for both dimensions.
 *   </p><P>
 *   If unset but <A HREF=#d:esep>esep</a> is defined, the <tt>sep</tt> values
 *   will be set to the <tt>esep</tt> values divided by <tt>0.8</tt>. 
 *   If <tt>esep</tt> is unset, the default value is used.
 */
class Sep extends AbstractAttributes
{                
    
    protected $name = "sep";

    public function __construct(AttributeType $value)
    {
        if (! $value instanceof AddDoubleType ) {
            throw new \Exception("value $value not allowed, should be of type AddDoubleType");
        }
        parent::__construct($value);
    }    
}
