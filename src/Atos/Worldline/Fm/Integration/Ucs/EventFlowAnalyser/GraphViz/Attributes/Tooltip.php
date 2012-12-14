<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Tooltip annotation attached to the node or edge. If unset, Graphviz
 *   will use the object's <A HREF=#dlabel>label</a> if defined.
 *   Note that if the label is a record specification or an HTML-like
 *   label, the resulting tooltip may be unhelpful. In this case, if
 *   tooltips will be generated, the user should set a <TT>tooltip</tt>
 *   attribute explicitly.
 */
class Tooltip extends AbstractAttributes
{                
    
    protected $name = "tooltip";
}
