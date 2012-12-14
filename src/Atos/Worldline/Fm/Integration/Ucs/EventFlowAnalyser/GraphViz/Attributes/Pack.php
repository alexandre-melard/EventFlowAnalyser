<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This is true if the value of pack is "true" (case-insensitive) or a
 *   non-negative integer. If true, each connected component of the graph is
 *   laid out separately, and then the graphs are packed together.
 *   If pack has an integral value, this is used as the size,
 *   in <A HREF=#points>points</a>, of
 *   a margin around each part; otherwise, a default margin of 8 is used.
 *   If pack is interpreted as false, the entire graph is laid out together.
 *   The granularity and method of packing is influenced by the
 *   <A HREF=#dpackmode>packmode</a> attribute.
 *   <P>
 *   For layouts which always do packing, such a twopi, the <B>pack</b>
 *   attribute is just used to set the margin.
 */
class Pack extends AbstractAttributes
{                
    
    protected $name = "pack";
}
