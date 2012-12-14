<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;
use Biplane\EnumBundle\Enumeration\Enum;

/**
 * The table below describes the attributes used by various Graphviz tools.
 * The table gives the name of the attribute, the graph components (node,
 * edge, etc.) which use the attribute and the type of the attribute
 * (strings representing legal values of that type). Where applicable, the table
 * also gives a default value for the attribute, a minimum allowed setting
 * for numeric attributes, and certain restrictions on the use of the attribute.
 */
abstract class AbstractAttributeType extends Enum implements AttributeType
{
    protected $value;

    /**
     * @param unknown $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    static function getPossibleValues()
    {
        return array();
    }

    static function getReadables()
    {
        return array();
    }

    public function __toString()
    {
        return $this->value;
    }
}
