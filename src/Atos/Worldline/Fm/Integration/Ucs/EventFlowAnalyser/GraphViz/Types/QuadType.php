<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* "normal", "fast", "none". 
*   <P>
*   Using "fast" gives about a 2-4 times overall speedup compared with "normal", 
*   though layout quality can suffer a little. 
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "quadType";
}
