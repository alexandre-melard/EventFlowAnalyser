<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Rank constraints on the nodes in a subgraph.
 *   If <B>rank</b>="same", all nodes are placed on the same rank.
 *   If <B>rank</b>="min", all nodes are placed on the minimum rank.
 *   If <B>rank</b>="source", all nodes are placed on the minimum rank, and
 *   the only nodes on the minimum rank belong to some subgraph whose
 *   rank attribute is "source" or "min".
 *   Analogous criteria hold for <B>rank</b>="max" and <B>rank</b>="sink".
 *   (Note: the
 *   minimum rank is topmost or leftmost, and the maximum rank is bottommost
 *   or rightmost.)
 */
class Rank extends AbstractAttributes
{                
    
    protected $name = "rank";
}
