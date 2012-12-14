<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Distortion factor for <A HREF=#dshape><B>shape</b></a>=polygon.
 *   Positive values cause top part to
 *   be larger than bottom; negative values do the opposite.
 */
class Distortion extends AbstractAttributes
{                
    
    protected $name = "distortion";
}
