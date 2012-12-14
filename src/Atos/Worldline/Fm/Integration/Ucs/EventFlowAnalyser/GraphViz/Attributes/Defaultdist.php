<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This specifies the distance between nodes in separate connected
 *   components. If set too small, connected components may overlap.
 *   Only applicable if <A HREF=#dpack>pack</a>=false.
 */
class Defaultdist extends AbstractAttributes
{                
    
    protected $name = "defaultdist";
}
