<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Tooltip annotation attached to the non-label part of an edge.
 *   This is used only if the edge has a <A HREF=#dURL>URL</a>
 *   or <A HREF=#d:edgeURL>edgeURL</a> attribute.
 */
class Edgetooltip extends AbstractAttributes
{                
    
    protected $name = "edgetooltip";
}
