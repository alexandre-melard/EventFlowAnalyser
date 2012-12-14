<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Technique for optimizing the layout. For neato, if <B>mode</b> is <TT>"major"</tt>,
 *   neato uses stress majorization. If <B>mode</b> is <TT>"KK"</tt>,
 *   neato uses a version of the gradient descent method. The only advantage
 *   to the latter technique is that it is sometimes appreciably faster for
 *   small (number of nodes &lt; 100) graphs. A significant disadvantage is that
 *   it may cycle.
 *   <P>
 *   There are two experimental modes in neato, "hier", which adds a top-down
 *   directionality similar to the layout used in dot, and "ipsep", which
 *   allows the graph to specify minimum vertical and horizontal distances
 *   between nodes. (See the <A HREF=#dsep>sep</a> attribute.)
 *   <TT>"len"</tt> attribute.
 */
class Mode extends AbstractAttributes
{                
    
    protected $name = "mode";
}
