<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Used to set number of iterations in
 *   network simplex applications. <B>nslimit</b> is used in
 *   computing node x coordinates, <B>nslimit1</b> for ranking nodes.
 *   If defined, # iterations =  <B>nslimit(1)</b> * # nodes;
 *   otherwise,  # iterations = MAXINT.
 */
class Nslimit1 extends AbstractAttributes
{                
    
    protected $name = "nslimit1";
}
