<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* list of strings separated by characters from the
*   <A HREF=#alayersep>layersep</a> attribute (by default, colons,
*   tabs or spaces), defining <A HREF=#alayer>layer</a>
*   names and implicitly numbered 1,2,...
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "layerList";
    
}
