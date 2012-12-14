<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Bounding box of drawing in points.
 */
class Bb extends AbstractAttributes
{
    
    protected $name = "bb";
    
    public function __construct(Rect $value)
    {
        parent::__construct($value);
    }
}
