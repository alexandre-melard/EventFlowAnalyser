<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This value specifies how the distance matrix is computed for the input
 *   graph. The distance matrix specifies the ideal distance between every
 *   pair of nodes. neato attemps to find a layout which best achieves
 *   these distances. By default, it uses the length of the shortest path,
 *   where the length of each edge is given by its <A HREF=#dlen>len</a>
 *   attribute. If <B>model</b> is <TT>"circuit"</tt>, neato uses the
 *   circuit resistance
 *   model to compute the distances. This tends to emphasize clusters. If
 *   <B>model</b> is <TT>"subset"</tt>, neato uses the subset model. This sets the
 *   edge length to be the number of nodes that are neighbors of exactly one
 *   of the end points, and then calculates the shortest paths. This helps
 *   to separate nodes with high degree.
 *   <P>
 *   For more control of distances, one can use <TT>model=mds</tt>. In this
 *   case, the <A HREF=#dlen>len</a> of an edge is used as the ideal distance
 *   between its vertices. A shortest path calculation is only used for
 *   pairs of nodes not connected by an edge. Thus, by supplying a complete
 *   graph, the input can specify all of the relevant distances.
 */
class Model extends AbstractAttributes
{                
    
    protected $name = "model";
}
