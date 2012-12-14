<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Clipping window on final drawing. Note that this attribute supersedes any
 *   <A HREF="#dsize">size</a> attribute. The width and height of the viewport specify
 *   precisely the final size of the output. 
 */
class Viewport extends AbstractAttributes
{                
    
    protected $name = "viewport";
}
