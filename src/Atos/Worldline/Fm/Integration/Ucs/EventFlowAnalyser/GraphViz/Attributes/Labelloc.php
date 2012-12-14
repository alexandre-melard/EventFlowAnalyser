<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Vertical placement of labels for nodes, root graphs and clusters.
 *   <P>
 *   For graphs and clusters, only "t" and "b" are allowed, corresponding
 *   to placement at the top and bottom, respectively.
 *   By default, root
 *   graph labels go on the bottom and cluster labels go on the top.
 *   Note that a subgraph inherits attributes from its parent. Thus, if
 *   the root graph sets <B>labelloc</b> to "b", the subgraph inherits
 *   this value.
 *   </p><P>
 *   For nodes, this attribute is used only when the height of the node
 *   is larger than the height of its label. 
 *   If <TT>labelloc</tt> is set to "t", "c", or "b", the label is aligned
 *   with the top, centered, or aligned with the bottom of the node, respectively.
 *   In the default case, the label is vertically centered.
 */
class Labelloc extends AbstractAttributes
{                
    
    protected $name = "labelloc";
}
