<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\AttributeType;

interface Attributes
{
    /**
     * @return AttributeType
     */
    public function getValue();
    
    /**
     * @return string
     */
    public function getName();
}
