<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\DoubleType;

/**
 * Multiplicative scale factor for arrowheads.
 */
class Arrowsize extends AbstractAttributes
{
    
    protected $name = "arrowsize";
    
    public function __construct(DoubleType $value)
    {
        parent::__construct($value);
    }
}
