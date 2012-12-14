<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Mode used for handling clusters. If <B>clusterrank</b> is "local", a
 *   subgraph whose name begins with "cluster" is given special treatment.
 *   The subgraph is laid out separately, and then integrated as a unit into
 *   its parent graph, with a bounding rectangle drawn about it.
 *   If the cluster has a <A HREF=#dlabel>label</a> parameter, this label
 *   is displayed within the rectangle.
 *   Note also that there can be clusters within clusters.
 *   At present, the modes "global" and "none"
 *   appear to be identical, both turning off the special cluster processing.
 */
class Clusterrank extends AbstractAttributes
{        
    
    protected $name = "clusterrank";
}
