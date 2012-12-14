<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Sets direction of graph layout. For example, if <B>rankdir</b>="LR",
 *   and barring cycles, an edge <CODE>T -> H;</code> will go
 *   from left to right. By default, graphs are laid out from top to bottom.
 *   <P>
 *   This attribute also has a side-effect in determining how record nodes
 *   are interpreted. See <A HREF="node-shapes#record">record shapes</a>.
 */
class Rankdir extends AbstractAttributes
{                
    
    protected $name = "rankdir";
}
