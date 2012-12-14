<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Color used to fill the background of a node or cluster
 *   assuming <A HREF=#dstyle>style</a>=filled, or a filled arrowhead.
 *   If <B>fillcolor</b> is not defined, <A HREF=#dcolor>color</a> is
 *   used. (For clusters, if <B>color</b> is not defined,
 *   <A HREF=#dbgcolor>bgcolor</a> is used.) If this is not defined,
 *   the default is used, except for
 *   <A HREF=#dshape><B>shape</b></a>=point or when the output
 *   format is MIF,
 *   which use black by default.
 *   <P>
 *   If the value is a <A HREF=#kcolorList>colorList</a>, a gradient fill is
 *   used. By default, this is a linear fill; setting <TT>style=radial</tt> will
 *   cause a radial fill. At present, only two colors are used. If the second
 *   color (after a colon) is missing, the default color is used for it.
 *   See also the <A HREF=#dgradientangle>gradientangle</a> attribute
 *   for setting the gradient angle. 
 *   </p><P>
 *   Note that a cluster inherits the root graph's attributes if defined.
 *   Thus, if the root graph has defined a <B>fillcolor</b>, this will override a
 *   <B>color</b> or <B>bgcolor</b> attribute set for the cluster.
 */
class Fillcolor extends AbstractAttributes
{                
    
    protected $name = "fillcolor";
}
