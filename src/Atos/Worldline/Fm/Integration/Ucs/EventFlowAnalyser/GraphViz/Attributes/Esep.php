<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Margin used around polygons for purposes of spline edge routing.
 *   The interpretation is the same as given for <A HREF=#dsep>sep</a>.
 *   This should normally be strictly less than <A HREF=#dsep>sep</a>.
 */
class Esep extends AbstractAttributes
{                
    
    protected $name = "esep";
}
