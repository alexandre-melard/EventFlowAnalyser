<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* <p>An aspect ratio, double, followed optionally by a ',' and a maximum pass 
*   count. If the aspect ratio is given, but no maximum pass count, the
*   latter defaults to 5.
*/
class AspectType extends AbstractAttributeType
{
    protected $name = "aspectType";
}
