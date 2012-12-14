<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This indicates how connected components should be packed
 *   (cf. <A HREF=#kpackMode>packMode</a>). Note that defining
 *   <B>packmode</b> will automatically turn on packing as though one had
 *   set <B>pack=true</b>.
 */
class Packmode extends AbstractAttributes
{                
    
    protected $name = "packmode";
}
