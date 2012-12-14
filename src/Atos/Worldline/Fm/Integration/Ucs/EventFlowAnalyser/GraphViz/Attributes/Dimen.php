<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Set the number of dimensions used for rendering. 
 *   The maximum value allowed is 10.
 *   If both <TT>dimen</tt> and <TT>dim</tt> are set, the latter specifies
 *   the dimension used for layout, and the former for rendering.
 *   If only <TT>dimen</tt> is set, this is used for both layout and rendering
 *   dimensions.
 *   <P>
 *   Note that, at present, all aspects of rendering are 2D. This includes
 *   the shape and size of nodes, overlap removal, and edge routing. Thus,
 *   for <TT>dimen &gt; 2</tt>, the only valid information is the <TT>pos</tt>
 *   attribute of the nodes.
 *   All other coordinates will be 2D and, at best, will reflect a projection
 *   of a higher-dimensional point onto the plane.
 */
class Dimen extends AbstractAttributes
{                
    
    protected $name = "dimen";
}
