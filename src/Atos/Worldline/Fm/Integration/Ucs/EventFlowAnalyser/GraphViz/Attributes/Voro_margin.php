<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Factor to scale up drawing to allow margin for expansion in
 *   Voronoi technique. dim' = (1+2*margin)*dim.
 */
class Voro_margin extends AbstractAttributes
{                
    
    protected $name = "voro_margin";
}
