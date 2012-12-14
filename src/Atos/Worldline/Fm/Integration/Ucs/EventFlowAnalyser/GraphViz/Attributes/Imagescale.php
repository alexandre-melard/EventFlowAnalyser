<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Attribute controlling how an image fills its
 *   containing node. In general, the image is given its natural size,
 *   (cf. <A HREF=#ddpi>dpi</a>),
 *   and the node size is made large enough to contain its image, its
 *   label, its margin, and its peripheries.
 *   Its width and height will also be at least as large as its
 *   minimum <A HREF=#dwidth>width</a> and <A HREF=#dheight>height</a>.
 *   If, however, <TT>fixedsize=true</tt>,
 *   the width and height attributes specify the exact size of the node.
 *   <P>
 *   During rendering, in the default case (<TT>imagescale=false</tt>),
 *   the image retains its natural size.
 *   If <TT>imagescale=true</tt>,
 *   the image is uniformly scaled (i.e., its aspect ratio is
 *   preserved) to fit inside the node.
 *   At least one dimension of the image will be as large as possible
 *   given the size of the node.
 *   When <TT>imagescale=width</tt>,
 *   the width of the image is scaled to fill the node width.
 *   The corresponding property holds when <TT>imagescale=height</tt>.
 *   When <TT>imagescale=both</tt>,
 *   both the height and the width are scaled separately to fill the node.
 *   </p><P>
 *   In all cases, if a dimension of the image is larger than the
 *   corresponding dimension of the node, that dimension of the
 *   image is scaled down to fit the node. As with the case of
 *   expansion, if  <TT>imagescale=true</tt>, width and height are
 *   scaled uniformly.
 */
class Imagescale extends AbstractAttributes
{                
    
    protected $name = "imagescale";
}
