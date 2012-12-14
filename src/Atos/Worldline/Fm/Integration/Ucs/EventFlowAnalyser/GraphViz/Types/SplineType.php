<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* spline ( ';' spline )*<BR />
*   <TABLE>
*    <TR><TD ALIGN=right>where spline<TD>=<TD>(endp)? (startp)? point (triple)+</td></td></td></tr>
*    <TR><TD ALIGN=right>and triple<TD>=<TD>point point point</td></td></td></tr>
*    <TR><TD ALIGN=right>and endp<TD>=<TD>"e,%f,%f"</td></td></td></tr>
*    <TR><TD ALIGN=right>and startp<TD>=<TD>"s,%f,%f"</td></td></td></tr>
*   </table>
*   If a spline has points p<SUB>1</sub> p<SUB>2</sub> p<SUB>3</sub> ... p<SUB>n</sub>, (n = 1 (mod 3)), the points
*    correspond to the control points of a cubic B-spline from p<SUB>1</sub> to p<SUB>n</sub>. If startp
*    is given, it touches one node of the edge, and the arrowhead
*    goes from p<SUB>1</sub> to startp. If startp is not given, p<SUB>1</sub> touches a node.
*    Similarly for p<SUB>n</sub>  and endp.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "splineType";   
}
