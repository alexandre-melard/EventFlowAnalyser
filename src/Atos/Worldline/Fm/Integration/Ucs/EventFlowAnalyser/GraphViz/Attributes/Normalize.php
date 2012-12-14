<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If set, normalize coordinates of final
 *   layout so that the first point is at the origin, and then rotate the
 *   layout so that the first edge is horizontal.
 */
class Normalize extends AbstractAttributes
{                
    
    protected $name = "normalize";
}
