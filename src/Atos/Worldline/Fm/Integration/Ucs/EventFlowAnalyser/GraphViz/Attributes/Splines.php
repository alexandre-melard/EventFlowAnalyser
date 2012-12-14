<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Controls how, and if, edges are represented. If true, edges are drawn as
 *   splines routed around nodes; if false, edges are drawn as line segments.
 *   If set to <tt>none</tt> or "", no edges are drawn at all.
 *   <P>
 *   (1 March 2007) The values <TT>line</tt> and <TT>spline</tt> can be
 *   used as synonyms for <TT>false</tt> and <TT>true</tt>, respectively.
 *   In addition, the value <TT>polyline</tt> specifies that edges should be
 *   drawn as polylines.
 *   </p><P>
 *   (28 Sep 2010) The value <TT>ortho</tt> specifies edges should be
 *   routed as polylines of axis-aligned segments. Currently, the routing
 *   does not handle ports or, in dot, edge labels.
 *   </p><P>
 *   (25 Sep 2012) The value <TT>curved</tt> specifies edges should be
 *   drawn as curved arcs.
 *   </p><P>
 *   <TABLE>
 *   <TR><TD><IMG WIDTH="200" VSPACE="10" HSPACE="10" SRC="/doc/info/spline_none.png" />
 *       <TD><IMG WIDTH="200" VSPACE="10" HSPACE="10" SRC="/doc/info/spline_line.png" />
 *       <TD><IMG WIDTH="200" VSPACE="10" HSPACE="10" SRC="/doc/info/spline_polyline.png" />
 *       <TD><IMG WIDTH="200" VSPACE="10" HSPACE="10" SRC="/doc/info/spline_curved.png" />
 *       <TD><IMG WIDTH="200" VSPACE="10" HSPACE="10" SRC="/doc/info/spline_ortho.png" />
 *       <TD><IMG WIDTH="200" VSPACE="10" HSPACE="10" SRC="/doc/info/spline_spline.png" />
 *   </td></td></td></td></td></td></tr>
 *   <TR><TD ALIGN="center">splines=none<BR />splines=""
 *       <TD ALIGN="center">splines=line<BR />splines=false
 *       <TD ALIGN="center">splines=polyline
 *       <TD ALIGN="center">splines=curved
 *       <TD ALIGN="center">splines=ortho
 *       <TD ALIGN="center">splines=spline<BR />splines=true
 *   </td></td></td></td></td></td></tr>
 *   </table>
 *   
 *   </p><P>
 *   By default, the attribute is unset. How this is interpreted depends on
 *   the layout. For dot, the default is to draw edges as splines. For all
 *   other layouts, the default is to draw edges as line segments. Note that
 *   for these latter layouts, if <TT>splines="true"</tt>, this
 *   requires non-overlapping nodes (cf. <A HREF=#doverlap><B>overlap</b></a>).
 *   If fdp is used for layout and <TT>splines="compound"</tt>, then the edges are
 *   drawn to avoid clusters as well as nodes.
 */
class Splines extends AbstractAttributes
{                
    
    protected $name = "splines";
}
