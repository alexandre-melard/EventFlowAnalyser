<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* A colon-separated list of weighted color values: <I>WC</i>(:<I>WC</i>)*
*   where each <I>WC</i> has the form <I>C(;F)?</i> with C a <A HREF=#kcolor>color</a> value
*   and the optional <I>F</i> a floating-point number, 0 &le; <I>F</i> &le; 1. The sum of the 
*   floating-point numbers in a <TT>colorList</tt> must sum to at most 1.
*   <P>
*   Depending on the related attribute and graph object, two colors may specify a gradient fill.
*   The following table shows some variations of the <TT>yellow:blue</tt> color list depending on the
*   <A HREF=#astyle>style</a> and <A HREF=#agradientangle>gradientangle</a> attributes.
*     <TABLE border=1>
*       <TR><TH>Gradient angle<TH>Linear<TH>Radial</th></th></th></tr>
*       <TR><TD align=center>0<TD><IMG SRC="/doc/info/g_lin0.png" /><TD><IMG SRC="/doc/info/g_rad0.png" /></td></td></td></tr>
*       <TR><TD align=center>45<TD><IMG SRC="/doc/info/g_lin45.png" /><TD><IMG SRC="/doc/info/g_rad45.png" /></td></td></td></tr>
*       <TR><TD align=center>90<TD><IMG SRC="/doc/info/g_lin90.png" /><TD><IMG SRC="/doc/info/g_rad90.png" /></td></td></td></tr>
*       <TR><TD align=center>180<TD><IMG SRC="/doc/info/g_lin180.png" /><TD><IMG SRC="/doc/info/g_rad180.png" /></td></td></td></tr>
*       <TR><TD align=center>270<TD><IMG SRC="/doc/info/g_lin270.png" /><TD><IMG SRC="/doc/info/g_rad270.png" /></td></td></td></tr>
*       <TR><TD align=center>360<TD><IMG SRC="/doc/info/g_lin360.png" /><TD><IMG SRC="/doc/info/g_rad360.png" /></td></td></td></tr>
*     </table>
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "colorList";
}
