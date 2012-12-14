<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If true, use edge concentrators.
 *   This merges multiedges into a single edge and causes partially parallel
 *   edges to share part of their paths. The latter feature is not yet available
 *   outside of dot.
 */
class Concentrate extends AbstractAttributes
{                
    
    protected $name = "concentrate";
}
