<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Multiplicative scale factor used to alter the MinQuit (default = 8)
 *   and MaxIter (default = 24) parameters used during crossing
 *   minimization. These correspond to the
 *   number of tries without improvement before quitting and the
 *   maximum number of iterations in each pass.
 */
class Mclimit extends AbstractAttributes
{                
    
    protected $name = "mclimit";
}
