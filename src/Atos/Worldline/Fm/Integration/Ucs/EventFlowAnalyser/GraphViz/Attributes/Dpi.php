<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This specifies the expected number of pixels per inch on a display device.
 *   For bitmap output, this guarantees that text rendering will be
 *   done more accurately, both in size and in placement. For SVG output,
 *   it is used to guarantee that the dimensions in the output correspond to
 *   the correct number of points or inches.
 */
class Dpi extends AbstractAttributes
{                
    
    protected $name = "dpi";
}
