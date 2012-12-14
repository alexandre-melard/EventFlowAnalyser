<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * External label for a node or edge. For nodes, the label will be placed outside of the
 *   node but near it. For edges, the label will be placed near the center of the edge.
 *   This can be useful in dot to avoid the occasional problem when the use of edge labels
 *   distorts the layout. For other layouts, the xlabel attribute can be viewed as a synonym
 *   for the <A HREF=#dlabel><B>label</b></a> attribute.
 *   <P>
 *   These labels are added after all nodes and edges have been placed. The labels will be placed
 *   so that they do not overlap any node or label. This means it may not be possible to place all
 *   of them. To force placing all of them, use the  <A HREF=#dforcelabels><B>forcelabels</b></a> attribute.
 */
class Xlabel extends AbstractAttributes
{                
    
    protected $name = "xlabel";
}
