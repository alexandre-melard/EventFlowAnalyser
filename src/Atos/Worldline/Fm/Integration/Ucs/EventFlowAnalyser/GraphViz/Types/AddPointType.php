<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* <P>A <A HREF="kpoint">point</a> with an optional prefix '+'.
*/
class AddPointType extends AbstractAttributeType
{

    protected $name = "addPoint";
    public function __construct($value)
    {
        if ( 0 == preg_match('#^\+?\d+(\,\d+){1,2}$#', $value)) {
            throw new \Exception('value should be of form #^\+?\d+(\,\d+){1,2}$#');
        }
        parent::__construct($value);
    }
}
