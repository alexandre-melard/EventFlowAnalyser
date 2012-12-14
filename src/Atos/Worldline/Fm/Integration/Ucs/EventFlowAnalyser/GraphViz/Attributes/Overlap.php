<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Determines if and how node overlaps should be removed. Nodes are first
 *   enlarged using the <A HREF=#dsep><B>sep</b></a> attribute.
 *   If "true" , overlaps are retained.
 *   If the value is "scale", overlaps are removed by uniformly scaling in x and y.
 *   If the value converts to "false", and it is available, Prism, a proximity graph-based algorithm, is
 *   used to remove node overlaps.
 *   This can also be invoked explicitly with "overlap=prism".
 *   This technique starts with a
 *   small scaling up, controlled by the 
 *   <A HREF="#doverlap_scaling"><TT>overlap_scaling</tt></a> attribute,
 *   which can remove a significant portion of the overlap.
 *   The prism option also accepts an optional non-negative integer suffix.
 *   This can be used to control the number of attempts made at overlap
 *   removal. By default, <TT>overlap="prism"</tt> is equivalent to
 *   <TT>overlap="prism1000"</tt>. Setting <TT>overlap="prism0"</tt>
 *   causes only the scaling phase to be run.
 *   <P>
 *   If Prism is not available, or the version of Graphviz is earlier than 2.28, "overlap=false"
 *   uses a Voronoi-based technique.
 *   This can always be invoked explicitly with "overlap=voronoi".
 *   </p><P>
 *   If the value is "scalexy", x and y are separately
 *   scaled to remove overlaps.
 *   </p><P>
 *   If the value is "compress", the layout will be scaled down as much as
 *   possible without introducing any overlaps, obviously assuming there are
 *   none to begin with.
 *   </p><P>
 *   <B>N.B.</b>The remaining allowed values of <TT>overlap</tt>
 *   correspond to algorithms which, at present, can produce bad aspect ratios.
 *   In addition, we deprecate the use of the "ortho*" and "portho*".
 *   </p><P>
 *   If the value is "vpsc", overlap removal is done as a
 *   quadratic optimization to minimize node displacement while removing
 *   node overlaps.
 *   </p><P>
 *   If the value is "orthoxy" or "orthoyx", overlaps
 *   are moved by optimizing two constraint problems, one for the x axis and
 *   one for the y. The suffix indicates which axis is processed first.
 *   If the value is "ortho", the technique is similar to "orthoxy" except a
 *   heuristic is used to reduce the bias between the two passes.
 *   If the value is "ortho_yx", the technique is the same as "ortho", except
 *   the roles of x and y are reversed.
 *   The values "portho", "porthoxy", "porthoxy", and "portho_yx" are similar
 *   to the previous four, except only pseudo-orthogonal ordering is
 *   enforced.
 *   </p><P>
 *   If the layout is done by neato with <A HREF=#dmode>mode</a>="ipsep",
 *   then one can use <TT>overlap=ipsep</tt>.
 *   In this case, the overlap removal constraints are
 *   incorporated into the layout algorithm itself.
 *   N.B. At present, this only supports one level of clustering.
 *   </p><P>
 *   Except for fdp and sfdp, the layouts assume <TT>overlap="true"</tt> as the default.
 *   Fdp first uses a number of passes using a built-in, force-directed technique
 *   to try to remove overlaps. Thus, fdp accepts <B>overlap</b> with an integer
 *   prefix followed by a colon, specifying the number of tries. If there is
 *   no prefix, no initial tries will be performed. If there is nothing following
 *   a colon, none of the above methods will be attempted. By default, fdp
 *   uses <TT>overlap="9:prism"</tt>. Note that <TT>overlap="true"</tt>,
 *   <TT>overlap="0:true"</tt> and <TT>overlap="0:"</tt> all turn off all overlap
 *   removal.
 *   </p><P>
 *   By default, sfdp uses <TT>overlap="prism0"</tt>.
 *   </p><P>
 *   Except for the Voronoi and prism methods, all of these transforms preserve the
 *   orthogonal ordering of the original layout. That is, if the x coordinates
 *   of two nodes are originally the same, they will remain the same, and if
 *   the x coordinate of one node is originally less than the x coordinate of
 *   another, this relation will still hold in the transformed layout. The
 *   similar properties hold for the y coordinates.
 *   This is not quite true for the "porth*" cases. For these, orthogonal
 *   ordering is only preserved among nodes related by an edge.
 */
class Overlap extends AbstractAttributes
{                
    
    protected $name = "overlap";
}
