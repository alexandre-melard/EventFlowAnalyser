<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If Graphviz is built with MOSEK defined, mode=ipsep and mosek=true,
 *   the Mosek software (<a href="http://www.mosek.com" title="www.mosek.com">www.mosek.com</a>) is use to solve the ipsep constraints.
 */
class Mosek extends AbstractAttributes
{                
    
    protected $name = "mosek";
}
