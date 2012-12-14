<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\AspectType;

/**
 * Target aspect ratio (width of the layout divided by the height)
 *   of the graph drawing. If unset, dot minimizes the total edge length.
 *   For certain graphs, like those with large fan-in or fan-out, this can
 *   lead to very wide layouts. Setting <TT>aspect</tt> will cause dot to try
 *   to adjust the layout to get an aspect ratio close to that specified
 *   by <TT>aspect</tt>.
 *   <P>
 *   By default, dot will do 5 passes attempting to achieve the desired
 *   aspect ratio. For certain graphs, more passes will be needed to get
 *   close enough. The <TT>aspect</tt> attribute can also be used to 
 *   specify the maximum number of passes to try.
 *   </p><P>
 *   At present, there is no mechanism for widening a very tall layout.
 *   Also, the algorithm doesn't handle clusters, nor disconnected graphs.
 *   For the latter case, one can split the pipeline<BR />
 *   <TT>ccomps -x | dot | gvpack | neato -n2</tt>
 *   to get a similar effect.
 */
class Aspect extends AbstractAttributes
{
    
    protected $name = "aspect";
    
    public function __construct(AspectType $value)
    {
        parent::__construct($value);
    }
}
