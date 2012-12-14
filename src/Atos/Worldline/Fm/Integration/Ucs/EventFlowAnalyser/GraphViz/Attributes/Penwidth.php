<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Specifies the width of the pen, in points, used to draw lines and curves,
 *   including the boundaries of edges and clusters. The value is inherited
 *   by subclusters.
 *   It has no effect on text.
 *   <P>
 *   Previous to 31 January 2008, the effect of <TT>penwidth=<I>W</i></tt>
 *   was achieved by including <TT>setlinewidth(<I>W</i>)</tt>
 *   as part of a <A HREF=#dstyle><TT>style</tt></a> specification.
 *   If both are used, <TT>penwidth</tt> will be used.
 */
class Penwidth extends AbstractAttributes
{                
    
    protected $name = "penwidth";
}
