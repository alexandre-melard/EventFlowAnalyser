<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If the <A HREF=#dpage>page</a> attribute is set and applicable,
 *   this attribute specifies the order in which the pages are emitted.
 *   This is limited to one of the 8 row or column major orders.
 */
class Pagedir extends AbstractAttributes
{                
    
    protected $name = "pagedir";
}
