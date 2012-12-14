<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Height of node, in inches. This is taken as the initial, minimum height
 *   of the node. If <A HREF=#dfixedsize><B>fixedsize</b></a> is true, this
 *   will be the final height of the node. Otherwise, if the node label
 *   requires more height to fit, the node's height will be increased to
 *   contain the label. Note also that, if the output format is dot, the
 *   value given to <B>height</b> will be the final value.
 *   <P>
 *   If the node shape is regular, the width and height are made identical.
 *   In this case, if either the width or the height is set explicitly,
 *   that value is used.
 *   In this case, if both the width or the height are set explicitly,
 *   the maximum of the two values is used.
 *   If neither is set explicitly, the minimum of the two default values
 *   is used.
 */
class Height extends AbstractAttributes
{                
    
    protected $name = "height";
}
