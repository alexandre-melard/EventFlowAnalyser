<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* has the syntax <TT>(<I>style</i>)?(<I>seed</i>)?</tt>.
*   <P>
*   If <I>style</i> is present, it must be one of the strings <TT>"regular"</tt>,
*   <TT>"self"</tt>, or <TT>"random"</tt>. In the first case, the nodes are
*   placed regularly about a circle. In the second case,
*   an abbreviated version of neato is run to obtain the initial layout.
*   In the last case, the nodes are placed randomly in a unit square.
*   </p><P>
*   If <I>seed</i> is present, it specifies a seed for the random number
*   generator. If <I>seed</i> is a positive number, this is used as the
*   seed. If it is anything else,
*   the current time, and possibly the process id, is used to pick a seed,
*   thereby making the choice more random. In this case, the seed value
*   is stored in the graph.
*   </p><P>
*   If the value is just <TT>"random"</tt>, a time-based seed is chosen.
*   </p><P>
*   Note that input positions, specified by a node's
*   <A HREF=#dpos>pos</a>
*   attribute, are only used when the style is <TT>"random"</tt>.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "startType";
}
