<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* "%f,%f,%f,%f"  The rectangle llx,lly,urx,ury gives the coordinates, in
*    points, of the lower-left corner (llx,lly) and the upper-right corner
*    (urx,ury).
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "rect";
}