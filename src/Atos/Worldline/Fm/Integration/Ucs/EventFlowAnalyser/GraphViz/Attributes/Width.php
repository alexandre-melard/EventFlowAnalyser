<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Width of node, in inches. This is taken as the initial, minimum width
 *   of the node. If <A HREF=#dfixedsize><B>fixedsize</b></a> is true, this
 *   will be the final width of the node. Otherwise, if the node label
 *   requires more width to fit, the node's width will be increased to
 *   contain the label. Note also that, if the output format is dot, the
 *   value given to <B>width</b> will be the final value.
 *   <P>
 *   If the node shape is regular, the width and height are made identical.
 *   In this case, if either the width or the height is set explicitly,
 *   that value is used.
 *   In this case, if both the width or the height are set explicitly,
 *   the maximum of the two values is used.
 *   If neither is set explicitly, the minimum of the two default values
 *   is used.
 */
class Width extends AbstractAttributes
{                
    
    protected $name = "width";
}
