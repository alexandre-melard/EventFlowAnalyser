<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If the object has a URL, this attribute determines which window
 *   of the browser is used for the URL.
 *   See <A HREF="http://www.w3.org/TR/html401/present/frames.html#adef-target">W3C documentation</a>.
 */
class Target extends AbstractAttributes
{                
    
    protected $name = "target";
}
