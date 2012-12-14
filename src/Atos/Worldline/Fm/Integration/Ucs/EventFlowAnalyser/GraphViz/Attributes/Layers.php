<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Specifies a linearly ordered list of layer names attached to the graph
 *   The graph is then output in separate layers. Only those components
 *   belonging to the current output layer appear. For more information,
 *   see the page <A HREF="http://www.graphviz.org/wiki/how-use-drawing-layers-overlays">How to use drawing layers (overlays)</a>.
 */
class Layers extends AbstractAttributes
{                
    
    protected $name = "layers";
}
