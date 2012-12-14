<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * The power of the repulsive force used in an extended Fruchterman-Reingold 
 *   force directed model. Values larger than 1 tend to reduce 
 *   the warping effect at the expense of less clustering.
 */
class Repulsiveforce extends AbstractAttributes
{                
    
    protected $name = "repulsiveforce";
}
