<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Quadtree scheme to use.
 *   <P>
 *   A TRUE bool value corresponds to "normal";
 *   a FALSE bool value corresponds to "none".
 *   As a slight exception to the normal interpretation of bool,
 *   a value of "2" corresponds to "fast".
 */
class Quadtree extends AbstractAttributes
{                
    
    protected $name = "quadtree";
}
