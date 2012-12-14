<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If true and the node has a pos attribute on input, neato or fdp prevents the
 *   node from moving from the input position. This property can also be specified
 *   in the pos attribute itself (cf. the <A HREF=#kpoint>point</a> type).
 *   <P>
 *   <B>Note:</b> Due to an artifact of the implementation, final coordinates
 *   are translated to the origin. Thus, if you look at the output coordinates
 *   given in the (x)dot or plain format, pinned nodes will not have the same
 *   output coordinates as were given on input. If this is important, a
 *   simple workaround is to maintain the coordinates of a pinned node. The vector
 *   difference between the old and new coordinates will give the translation,
 *   which can then be subtracted from all of the appropriate coordinates.
 */
class Pin extends AbstractAttributes
{                
    
    protected $name = "pin";
}
