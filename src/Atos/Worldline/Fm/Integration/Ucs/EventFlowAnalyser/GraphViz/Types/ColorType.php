<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* Colors can be specified using one of four formats.
*          <TABLE><TR><TD>"#%2x%2x%2x"<TD>Red-Green-Blue (RGB)</td></td></tr>
*          <TR><TD>"#%2x%2x%2x%2x"<TD>Red-Green-Blue-Alpha (RGBA)</td></td></tr>
*          <TR><TD>"H[,&#160;]+S[,&#160;]+V"<TD>Hue-Saturation-Value (HSV) 0.0 &lt;= H,S,V &lt;= 1.0</td></td></tr>
*          <TR><TD>string<TD><A HREF=color-names>color name</a></td></td></tr></table>
*    The specification for the RGB and RGBA formats are the format strings used by
*    <TT>sscanf</tt> to scan the color value. Thus, these values have the form
*    "#RGB" or "#RGBA", where R, G, B, and A each consist of 2 hexidecimal
*    digits, and can be separated by whitespace. HSV colors have the form of 3
*    numbers between 0 and 1, separated by whitespace or commas.
*   <P>
*   String-valued color specifications are case-insensitive and interpreted
*   in the context of the current color scheme, as specified by the
*   <A HREF=#dcolorscheme>colorscheme</a> attribute. If this is undefined,
*   the X11 naming scheme will be used.
*   An initial <TT>"/"</tt> character can be used to override the use of
*   the <TT>colorscheme</tt> attribute. In particular, a single initial
*   <TT>"/"</tt> will cause the string to be evaluated using the default
*   X11 naming. If the color value has the form <TT>"/ssss/yyyy"</tt>,
*   the name <TT>yyyy</tt> is interpreted using the schema <TT>ssss</tt>.
*   If the color scheme name is empty, i.e., the color has the
*   form <TT>"//yyyy"</tt>, the <TT>colorscheme</tt> attribute is used.
*   Thus, the forms <TT>"yyyy"</tt> and <TT>"//yyyy"</tt> are
*   equivalent.
*   </p><P>At present, Graphviz recognizes the default color scheme <TT>X11</tt>,
*   and the <A HREF="color-names#brewer">Brewer color schemes</a> (cf. <A HREF="http://www.personal.psu.edu/faculty/c/a/cab38/ColorBrewer/ColorBrewer_intro.html">ColorBrewer</a>). Please note that Brewer
*   color schemes are covered by this <A HREF=color-names#brewer_license>license</a>.
*   </p><P>
*   Examples:<BR />
*     <TABLE border=1>
*       <TR><TH>Color<TH>RGB<TH>HSV<TH>String</th></th></th></th></tr>
*       <TR><TD align=center bgcolor=#ffffff>White<TD>"#ffffff"<TD>"0.000 0.000 1.000"<TD>"white"</td></td></td></td></tr>
*       <TR><TD align=center bgcolor=#000000><font color=white>Black</font><TD>"#000000"<TD>"0.000 0.000 0.000"<TD>"black"</td></td></td></td></tr>
*       <TR><TD align=center bgcolor=#ff0000>Red<TD>"#ff0000"<TD>"0.000 1.000 1.000"<TD>"red"</td></td></td></td></tr>
*       <TR><TD align=center bgcolor=#40e0d0>Turquoise<TD>"#40e0d0"<TD>"0.482 0.714 0.878"<TD>"turquoise"</td></td></td></td></tr>
*       <TR><TD align=center bgcolor=#a0522d>Sienna<TD>"#a0522d"<TD>"0.051 0.718 0.627"<TD>"sienna"</td></td></td></td></tr>
*     </table>
*   </p><P>
*    The string value <TT>transparent</tt> can be used to indicate no color.
*    This is only available in the output formats
*    ps, svg, fig, vmrl, and the bitmap formats. It can be used whenever a
*    color is needed but is most useful with
*    the <A HREF=#dbgcolor>bgcolor</a> attribute.
*    Usually, the same effect can be achieved by setting
*    <A HREF=#dstyle>style</a> to <TT>invis</tt>.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "color";
}
