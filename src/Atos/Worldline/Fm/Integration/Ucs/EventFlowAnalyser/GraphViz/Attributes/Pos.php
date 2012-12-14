<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Position of node, or spline control points.
 *   For nodes, the position indicates the center of the node.
 *   On output, the coordinates are in <A HREF=#points>points</a>.
 *   <P>
 *   In neato and fdp, pos can be used to set the initial position of a node.
 *   By default, the coordinates are assumed to be in inches. However, the
 *   <A HREF=command-line-invocation#ds>-s</a> command line flag can be used to specify
 *   different units. As the output coordinates are in points, 
 *   feeding the output of a graph laid out by a Graphviz program into
 *   neato or fdp will almost always require the -s flag.
 *   </p><P>
 *   When the <A HREF=command-line-invocation#dn>-n</a> command line flag is used with
 *   neato, it is assumed the positions have been set by one of the layout
 *   programs, and are therefore in points. Thus, <TT>neato -n</tt> can accept
 *   input correctly without requiring a <TT>-s</tt> flag and, in fact,
 *   ignores any such flag.
 */
class Pos extends AbstractAttributes
{                
    
    protected $name = "pos";
}
