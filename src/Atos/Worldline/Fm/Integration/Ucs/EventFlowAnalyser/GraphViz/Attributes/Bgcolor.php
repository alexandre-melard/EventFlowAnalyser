<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * When attached to the root graph, this color is used as the background for
 *   entire canvas. When a cluster attribute, it is used as the initial
 *   background for the cluster. If a cluster has a filled
 *   <A HREF=#dstyle>style</a>, the
 *   cluster's <A HREF=#dfillcolor>fillcolor</a> will overlay the
 *   background color.
 *   <P>
 *   If the value is a <A HREF=#kcolorList>colorList</a>, a gradient fill is
 *   used. By default, this is a linear fill; setting <TT>style=radial</tt> will
 *   cause a radial fill. At present, only two colors are used. If the second
 *   color (after a colon) is missing, the default color is used for it.
 *   See also the <A HREF=#dgradientangle>gradientangle</a> attribute
 *   for setting the gradient angle. 
 *   </p><P>
 *   If no background color is specified for the root graph, no graphics
 *   operation are performed on the background. This works fine for
 *   PostScript but for bitmap output, all bits are initialized to something.
 *   This means that when the bitmap output is included in some other
 *   document, all of the bits within the bitmap's bounding box will be
 *   set, overwriting whatever color or graphics where already on the page.
 *   If this effect is not desired, and you only want to set bits explicitly
 *   assigned in drawing the graph, set <B>bgcolor</b>="transparent".
 */
class Bgcolor extends AbstractAttributes
{
    
    protected $name = "bgcolor";
}
