<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Text label attached to objects.
 *   If a node's <A HREF=#dshape>shape</a> is record, then the label can
 *   have a <A HREF=node-shapes#record>special format</a>
 *   which describes the record layout.
 */
class Label extends AbstractAttributes
{                
    
    protected $name = "label";
}
