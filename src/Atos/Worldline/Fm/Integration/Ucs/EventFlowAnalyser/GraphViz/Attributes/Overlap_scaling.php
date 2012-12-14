<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * When <TT>overlap=prism</tt>, the layout is scaled by this factor, thereby
 *   removing a fair amount of node overlap, and making node overlap removal
 *   faster and better able to retain the graph's shape.
 *   <P>
 *   If <TT>overlap_scaling</tt> is negative, the layout is scaled by
 *   <TT>-1*overlap_scaling</tt> times the average label size.
 *   If <TT>overlap_scaling</tt> is positive, the layout is scaled by
 *   <TT>overlap_scaling</tt>.
 *   If <TT>overlap_scaling</tt> is zero, no scaling is done.
 */
class Overlap_scaling extends AbstractAttributes
{                
    
    protected $name = "overlap_scaling";
}
