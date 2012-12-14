<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Specifies strictness of level constraints in neato
 *   when <TT><A HREF=#dmode>mode</a>="ipsep" or "hier"</tt>.
 *   Larger positive values mean stricter constraints, which demand more
 *   separation between levels. On the other hand, negative values will relax
 *   the constraints by allowing some overlap between the levels.
 */
class Levelsgap extends AbstractAttributes
{                
    
    protected $name = "levelsgap";
}
