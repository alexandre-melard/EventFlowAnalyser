<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Only valid when <A HREF=#dmode>mode</a>="ipsep".
 *   If true, constraints are generated for each edge in the largest (heuristic)
 *   directed acyclic subgraph such that the edge must point downwards.
 *   If "hier", generates level constraints similar to those used with
 *   <A HREF=#dmode>mode</a>="hier". The main difference is that, in the latter
 *   case, only these constraints are involved, so a faster solver can be used.
 */
class Diredgeconstraints extends AbstractAttributes
{                
    
    protected $name = "diredgeconstraints";
}
