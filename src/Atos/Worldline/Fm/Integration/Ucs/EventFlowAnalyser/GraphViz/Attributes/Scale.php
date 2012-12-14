<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If set, after the initial layout, twopi will scale the layout by the given factors.
 *   The scaling uses the root node of each component as the center of the scaling.
 *   If only a single number is given, this is used for both factors.
 */
class Scale extends AbstractAttributes
{                
    
    protected $name = "scale";
}
