<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* For an edge <CODE>T -> H;</code>
*     <TABLE>
*     <TR><TD>"forward"<TD><IMG SRC="/doc/info/forward.gif" />
*         <TD>"back"<TD><IMG SRC="/doc/info/back.gif" /></td></td></td></td></tr>
*     <TR><TD>"both"<TD><IMG SRC="/doc/info/both.gif" />
*         <TD>"none"<TD><IMG SRC="/doc/info/nohead.gif" /></td></td></td></td></tr>
*     </table>
*   That is, a glyph is drawn at the head end of an edge if and only
*   if dirType is "forward" or "both";
*   a glyph is drawn at the tail end of an edge if and only
*   if dirType is "back" or "both";
*   <P>
*   For undirected edges <CODE>T -- H;</code>, one of the nodes, usually
*   the righthand one, is treated as the head for the purpose of
*   interpreting "forward" and "back".
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "dirType";
}
