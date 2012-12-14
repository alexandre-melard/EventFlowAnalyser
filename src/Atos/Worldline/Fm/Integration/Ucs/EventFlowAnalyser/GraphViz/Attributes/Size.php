<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Maximum width and height of drawing, in inches.
 *   If only a single number is given, this is used for both the width
 *   and the height.
 *   <P>
 *   If defined and the drawing is larger than the given size, 
 *   the drawing is uniformly
 *   scaled down so that it fits within the given size.
 *   </p><P>
 *   If <TT>size</tt> ends in an exclamation point (<TT>!</tt>),
 *   then it is taken to be
 *   the desired size. In this case, if both dimensions of the drawing are
 *   less than <TT>size</tt>, the drawing is scaled up uniformly until at
 *   least one dimension equals its dimension in <TT>size</tt>.
 *   </p><P>
 *   Note that there is some interaction between the <B>size</b> and
 *   <A HREF=#dratio><B>ratio</b></a> attributes.
 */
class Size extends AbstractAttributes
{                
    
    protected $name = "size";
}
