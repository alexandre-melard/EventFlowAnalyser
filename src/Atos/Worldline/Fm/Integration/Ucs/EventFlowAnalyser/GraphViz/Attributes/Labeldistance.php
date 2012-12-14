<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Multiplicative scaling factor adjusting the distance that
 *   the headlabel(taillabel) is from the head(tail) node.
 *   The default distance is 10 points. See <A HREF=#dlabelangle>labelangle</a>
 *   for more details.
 */
class Labeldistance extends AbstractAttributes
{                
    
    protected $name = "labeldistance";
}
