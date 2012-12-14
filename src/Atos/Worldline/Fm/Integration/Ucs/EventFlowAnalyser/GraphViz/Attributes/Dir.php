<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Set edge type for drawing arrowheads. This indicates which ends of the
 *   edge should be decorated with an arrowhead. The actual style of the
 *   arrowhead can be specified using the <A HREF=#darrowhead>arrowhead</a>
 *   and <A HREF=#darrowtail>arrowtail</a> attributes.
 *   See <A HREF=#h:undir_note>limitation</a>.
 */
class Dir extends AbstractAttributes
{                
    
    protected $name = "dir";
}
