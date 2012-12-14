<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If the end points of an edge belong to the same group, i.e., have the
 *   same group attribute, parameters are set to avoid crossings and keep
 *   the edges straight.
 */
class Group extends AbstractAttributes
{                
    
    protected $name = "group";
}
