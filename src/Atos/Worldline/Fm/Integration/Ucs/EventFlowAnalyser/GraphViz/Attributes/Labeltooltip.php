<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Tooltip annotation attached to label of an edge.
 *   This is used only if the edge has a <A HREF=#dURL>URL</a>
 *   or <A HREF=#dlabelURL>labelURL</a> attribute.
 */
class Labeltooltip extends AbstractAttributes
{                
    
    protected $name = "labeltooltip";
}
