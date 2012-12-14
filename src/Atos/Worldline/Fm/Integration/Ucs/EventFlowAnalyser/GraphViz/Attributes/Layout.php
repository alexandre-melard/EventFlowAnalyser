<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Specifies the name of the layout algorithm to use, such as "dot"
 *   or "neato". Normally, graphs should be kept independent of a type of
 *   layout. In some cases, however, it can be convenient to embed the type
 *   of layout desired within the graph. For example, a graph containing
 *   position information from a layout might want to record what the
 *   associated layout algorithm was.
 *   <P>
 *   This attribute takes precedence over 
 *   the <A HREF=command-line-invocation#minusK>-K flag</a> 
 *   or the actual command name used.
 */
class Layout extends AbstractAttributes
{                
    
    protected $name = "layout";
}
