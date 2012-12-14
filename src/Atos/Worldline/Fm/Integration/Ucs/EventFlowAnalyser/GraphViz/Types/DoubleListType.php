<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* A colon-separated list of doubles: "<I>%f</i>(:<I>%f</i>)*"
*    where each <I>%f</i> is a double.
*/
class DoubleListType extends AbstractAttributeType
{
    public function setValue($value)
    {
        if ( 0 == preg_match('#^\d+(\.\d+)?(\:\d+(\.\d+)?)*$#', $value)) {
            throw new \Exception('value should be of form #^\d+(\.\d+)?(\:\d+(\.\d+)?)*$#');
        }
        parent::setValue("\"$value\"");
    }
}
