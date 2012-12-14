<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* string allowing escape sequences which are replaced according
*   to the context.
*   For node attributes, the substring "'N" is replaced by the name of the node,
*   and the substring "'G" by the name of the graph.
*   For graph or cluster attributes, the substring "'G" is replaced by the
*   name of the graph or cluster.
*   For edge attributes, the substring "'E" is replaced by the name of the edge,
*   the substring "'G" is replaced by the name of the graph or cluster,
*   and the substrings "'T" and "'H" by the names of
*   the tail and head nodes, respectively.
*   The name of an edge is the string formed from the name of the
*   tail node, the appropriate edge operator ("--" or "->") and the name of the
*   head node.
*   In all cases, the substring "'L" is replaced by the object's label attribute.
*   <P>
*   In addition, if the associated attribute is
*   <A HREF=#alabel>label</a>,
*   <A HREF=#aheadlabel>headlabel</a> or <A HREF=#ataillabel>taillabel</a>,
*   the escape sequences "'n", "'l" and "'r"
*   divide the label into lines, centered, left-justified, and right-justified,
*   respectively.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "escString";
}
