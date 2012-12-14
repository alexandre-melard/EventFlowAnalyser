<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Basic drawing color for graphics, not text. For the latter, use the
 *   <A HREF=#dfontcolor>fontcolor</a> attribute.
 *   <P>
 *   For edges, the value
 *   can either be a single color or a <A HREF=#kcolorList>colorList</a>.
 *   In the latter case, the edge is drawn using parallel splines or lines,
 *   one for each color in the list, in the order given.
 *   The head arrow, if any, is drawn using the first color in the list,
 *   and the tail arrow, if any, the second color. This supports the common
 *   case of drawing opposing edges, but using parallel splines instead of
 *   separately routed multiedges. For example, the graph
 *   <PRE>
 *   digraph G {
 *     a -> b [dir=both color="red:blue"]
 *   }
 *   </pre>
 *   yields<BR />
 *   <IMG SRC="/doc/info/colorlist.gif" />
 */
class Color extends AbstractAttributes
{            
    
    protected $name = "color";
}
