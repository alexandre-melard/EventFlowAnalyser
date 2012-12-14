<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This specifies nodes to be used as the center of the
 *   layout and the root of the generated spanning tree. As a graph attribute,
 *   this gives the name of the node. As a node attribute (circo only), it
 *   specifies that the node should be used as a central node. In twopi,
 *   this will actually be the central node. In circo, the block containing
 *   the node will be central in the drawing of its connected component.
 *   If not defined,
 *   twopi will pick a most central node, and circo will pick a random node.
 *   <P>
 *   If the root attribute is defined as the empty string, twopi will reset it
 *   to name of the node picked as the root node.
 */
class Root extends AbstractAttributes
{                
    
    protected $name = "root";
}
