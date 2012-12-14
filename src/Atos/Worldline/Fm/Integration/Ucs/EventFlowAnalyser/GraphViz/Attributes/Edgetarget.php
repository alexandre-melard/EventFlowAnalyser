<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If the edge has a <A HREF=#dURL>URL</a> or <A HREF=#d:edgeURL>edgeURL</a>
 *   attribute, this attribute determines which window of the
 *   browser is used
 *   for the URL attached to the non-label part of the edge.
 *   Setting it to "_graphviz" will open a new window if it
 *   doesn't already exist, or reuse it if it does.
 *   If undefined, the value of the <A HREF=#dtarget>target</a> is used.
 */
class Edgetarget extends AbstractAttributes
{                
    
    protected $name = "edgetarget";
}
