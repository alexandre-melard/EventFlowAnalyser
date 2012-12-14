<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If false, the edge is not used in ranking the nodes. For example,
 *   in the graph
 *   <PRE>
 *   digraph G {
 *     a -> c;
 *     a -> b;
 *     b -> c [constraint=false];
 *   }
 *   </pre>
 *   the edge <CODE>b -> c</code> does not add a constraint during rank
 *   assignment, so the only constraints are that a be above b and c,
 *   yielding the graph:<BR />
 *   <IMG SRC="/doc/info/constraint.gif" />
 */
class Constraint extends AbstractAttributes
{                
    
    protected $name = "constraint";
}
