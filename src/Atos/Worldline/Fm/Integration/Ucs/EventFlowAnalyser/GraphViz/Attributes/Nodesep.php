<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * In dot, this specifies the minimum space between two adjacent nodes in the same rank, in inches.
 *   <P>
 *   For other layouts, this affects the spacing between loops on a single node, or multiedges between
 *   a pair of nodes.
 */
class Nodesep extends AbstractAttributes
{                
    
    protected $name = "nodesep";
}
