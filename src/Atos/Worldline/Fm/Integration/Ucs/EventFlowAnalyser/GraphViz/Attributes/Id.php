<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Allows the graph author to provide an id for graph objects which is to be included in the output.
 *   Normal "N", "E", "G" substitutions are applied.
 *   If provided, it is the reponsiblity of the provider to keep
 *   its values sufficiently unique for its intended downstream use.
 *   Note, in particular, that "E" does not provide a unique id for multi-edges.
 *   If no id attribute is provided, then a unique internal id is used. However, 
 *   this value is unpredictable by the graph writer.
 *   An externally provided id is not used internally.
 *   <P>
 *   If the graph provides an id attribute, this will be used as a prefix for
 *   internally generated attributes. By making these distinct, the user
 *   can include multiple image maps in the same document.
 */
class Id extends AbstractAttributes
{                
    
    protected $name = "id";
}
