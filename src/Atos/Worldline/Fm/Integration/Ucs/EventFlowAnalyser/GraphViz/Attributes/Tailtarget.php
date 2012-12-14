<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If the edge has a <A HREF=#dtailURL>tailURL</a>,
 *   this attribute determines which window of the
 *   browser is used
 *   for the URL. Setting it to "_graphviz" will open a new window if it
 *   doesn't already exist, or reuse it if it does.
 *   If undefined, the value of the <A HREF=#dtarget>target</a> is used.
 */
class Tailtarget extends AbstractAttributes
{                
    
    protected $name = "tailtarget";
}
