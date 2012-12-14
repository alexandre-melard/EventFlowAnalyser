<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * The value indicates
 *   whether to treat a node whose name has the form |edgelabel|* as a special node representing an edge label. 
 *   The default (0) produces no effect.
 *   If the attribute is set to 1, sfdp uses a penalty-based method to make that kind of node close to the 
 *   center of its neighbor. With a value of 2, sfdp uses a penalty-based method to make that kind of node 
 *   close to the old center of its neighbor. Finally, a value of 3 invokes a two-step process of overlap 
 *   removal and straightening.
 */
class Label_scheme extends AbstractAttributes
{                
    
    protected $name = "label_scheme";
}
