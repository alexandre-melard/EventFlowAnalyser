<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* styleItem ( ',' styleItem )*<BR />
*   <TABLE>
*   <TR><TD ALIGN=right>where styleItem<TD>=<TD>name or name'('args')'</td></td></td></tr>
*   <TR><TD ALIGN=right>and args<TD>=<TD>name ( ',' name )*</td></td></td></tr>
*   </table>
*   and name can be any string of characters not containing a space, a left or
*   right parenthesis, or a comma.
*   Note that whitespace characters are ignored.
*   <P>
*   At present, the recognized style names are
*   "dashed", "dotted", "solid", "invis" and "bold" for nodes and edges,
*   "tapered" for edges only,
*   and "filled", "striped", "wedged", "diagonals" and "rounded" for nodes only.
*   The styles "filled", "striped" and "rounded" are recognized for clusters.
*   The style "radial" is recognized for nodes, clusters and graphs, and indicates a
*   radial-style gradient fill if applicable.
*   The style "striped" is recognized for clusters and rectangularly-shaped nodes, and causes the
*   fill to be done as a set of vertical stripes. The colors are specified via a <A HREF=#kcolorList>colorList</a>, 
*   the colors drawn from left to right in list order. Optional color weights can be specified to indicate the
*   proportional widths of the bars. If the sum of the weights is less than 1, the remainder is divided evenly
*   among the colors with no weight. 
*   The style "wedged" is recognized for elliptically-shaped nodes, and causes the
*   fill to be done as a set of wedges. The colors are specified via a <A HREF=#kcolorList>colorList</a>, 
*   with the colors drawn counter-clockwise starting at angle 0. Optional color weights are interpreted
*   analogously to the striped case described above.
*   </p><P>
*   The following tables illustrate some of the effects of the style settings. 
*   Examples of tapered line styles are given below.
*   Examples of linear and radial gradient fill can be seen under  <A HREF=#kcolorList>colorList</a>.
*   </p><P>
*     <TABLE border=1>
*  <TR><TD align="center"><tt>solid</tt><TD align="center"><tt>dashed</tt><TD align="center"><tt>dotted</tt><TD align="center"><tt>bold</tt><TD align="center"><tt>rounded</tt><TD align="center"><tt>diagonals</tt><TD align="center"><tt>filled</tt><TD align="center"><tt>striped</tt><TD align="center"><tt>wedged</tt></td></td></td></td></td></td></td></td></td></tr>
*       <TR><TD><IMG SRC="/doc/info/n_solid.png" /><TD><IMG SRC="/doc/info/n_dashed.png" /><TD><IMG SRC="/doc/info/n_dotted.png" /><TD><IMG SRC="/doc/info/n_bold.png" /><TD><IMG SRC="/doc/info/n_rounded.png" /><TD><IMG SRC="/doc/info/n_diagonals.png" /><TD><IMG SRC="/doc/info/n_filled.png" /><TD><IMG SRC="/doc/info/n_striped.png" /><TD><IMG SRC="/doc/info/n_wedged.png" /></td></td></td></td></td></td></td></td></td></tr>
*       <CAPTION>Basic style settings for nodes</caption>
*     </table>
*   </p><P>
*     <TABLE border=1>
*       <TR><TD align="center"><tt>solid</tt><TD align="center"><tt>dashed</tt><TD align="center"><tt>dotted</tt><TD align="center"><tt>bold</tt></td></td></td></td></tr>
*       <TR><TD><IMG SRC="/doc/info/e_solid.png" /><TD><IMG SRC="/doc/info/e_dashed.png" /><TD><IMG SRC="/doc/info/e_dotted.png" /><TD><IMG SRC="/doc/info/e_bold.png" /></td></td></td></td></tr>
*       <CAPTION>Basic style settings for edges</caption>
*     </table>
*   </p><P>
*     <TABLE border=1>
*       <TR><TD align="center"><tt>solid</tt><TD align="center"><tt>dashed</tt><TD align="center"><tt>dotted</tt><TD align="center"><tt>bold</tt><TD align="center"><tt>rounded</tt><TD align="center"><tt>filled</tt><TD align="center"><tt>striped</tt></td></td></td></td></td></td></td></tr>
*       <TR><TD><IMG SRC="/doc/info/c_solid.png" /><TD><IMG SRC="/doc/info/c_dashed.png" /><TD><IMG SRC="/doc/info/c_dotted.png" /><TD><IMG SRC="/doc/info/c_bold.png" /><TD><IMG SRC="/doc/info/c_rounded.png" /><TD><IMG SRC="/doc/info/c_filled.png" /><TD><IMG SRC="/doc/info/c_striped.png" /></td></td></td></td></td></td></td></tr>
*       <CAPTION>Basic style settings for clusters</caption>
*     </table>
*   </p><P>
*   The effect of <tt>style=tapered</tt> depends on the <A HREF=#dpenwidth>penwidth</a>,
*   <A HREF=#ddir>dir</a>, <A HREF=#darrowhead>arrowhead</a> and <A HREF=#darrowtail>arrowtail</a> attributes.
*   The edge starts with width <tt>penwidth</tt> and tapers to width 1, in points. The <tt>dir</tt> attribute
*   determines whether the tapering goes from tail to head (<tt>dir=forward</tt>), from head to 
*   tail (<tt>dir=forward</tt>), from the middle to both the head and tail (<tt>dir=both</tt>), or no
*   tapering at all (<tt>dir=none</tt>). If the <tt>dir</tt> is not explicitly set, the default for the
*   graph type is used (see <A HREF=#adir>dir</a>). Arrowheads and arrowtails are also drawn, based on the
*   value of <tt>dir</tt>; to avoid this, set <tt>arrowhead</tt> and/or <TT>arrowtail</tt> to <TT>"none"</tt>.
*   </p><P>
*   The following table illustrates the <tt>style=tapered</tt> with <tt>penwidth=7</tt> and
*   <tt>arrowtail=none</tt>.
*     <TABLE border=1>
*       <TR><TD><tt>arrowhead</tt> &#92; <tt>dir</tt><TD align="center"><tt>forward</tt><TD align="center"><tt>back</tt><TD align="center"><tt>both</tt><TD align="center"><tt>none</tt></td></td></td></td></td></tr>
*       <TR><TD><tt>normal</tt><TD><IMG SRC="/doc/info/normal_forward.png" /><TD><IMG SRC="/doc/info/normal_back.png" /><TD><IMG SRC="/doc/info/normal_both.png" /><TD><IMG SRC="/doc/info/normal_none.png" /></td></td></td></td></td></tr>
*       <TR><TD><tt>none</tt><TD><IMG SRC="/doc/info/none_forward.png" /><TD><IMG SRC="/doc/info/none_back.png" /><TD><IMG SRC="/doc/info/none_both.png" /><TD><IMG SRC="/doc/info/none_none.png" /></td></td></td></td></td></tr>
*     </table>
*   </p><P>
*   Additional styles are available in
*   device-dependent form. Style lists are passed to device drivers, which
*   can use this to generate appropriate output.
*   </p><P>
*   The <TT>setlinewidth</tt> style value can be
*   used for more control over the width of node borders and edges than is
*   allowed by <TT>bold</tt>. This style value takes an argument, specifying the
*   width of the line in <A HREF=#points>points</a>. For example, <TT>style="bold"</tt> is
*   equivalent to <TT>style="setlinewidth(2)"</tt>.
*   <B>The use of <TT>setlinewidth</tt> is deprecated; one should use the
*   <A HREF=#dpenwidth><TT>penwidth</tt></a> attribute instead.</b>
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "style";
}
