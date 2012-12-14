<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* A string specifying the <A HREF=node-shapes>shape</a> of a node.
*   There are three
*   main types of shapes :
*   <A HREF=node-shapes#polygon>polygon-based</a>,
*   <A HREF=node-shapes#record>record-based</a> and
*   <A HREF=node-shapes#epsf>user-defined</a>.
*   The record-based shape has largely been superseded and greatly generalized
*   by <A HREF=node-shapes#html>HTML-like labels</a>. 
*   That is, instead of using <TT>shape=record</tt>, one might
*   consider using <TT>shape=none</tt> and an HTML-like label.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "shape";
}
