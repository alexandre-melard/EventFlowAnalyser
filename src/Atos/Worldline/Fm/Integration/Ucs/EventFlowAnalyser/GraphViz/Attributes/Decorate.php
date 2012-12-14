<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If true, attach edge label to edge by a 2-segment
 *   polyline, underlining the label, then going to the closest point of spline.
 */
class Decorate extends AbstractAttributes
{                
    
    protected $name = "decorate";
}
