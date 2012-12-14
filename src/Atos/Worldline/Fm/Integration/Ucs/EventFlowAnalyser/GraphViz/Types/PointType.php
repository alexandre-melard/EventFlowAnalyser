<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* "%f,%f('!')?" representing the point (x,y). The
*   optional '!' indicates the
*   node position should not change (input-only).
*   <P>
*   If <A HREF=#ddim>dim</a> is 3, <B>point</b> may also have
*   the format "%f,%f,%f('!')?" to represent the point (x,y,z).
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "point";
}
