<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* modifier indicating where on a node an edge should be aimed.
*   It has the form <TT><I>portname</i>(:<I>compass_point</i>)?</tt>
*   or <TT><I>compass_point</i></tt>.
*   If the first form is used, the corresponding node must either have
*   <A HREF=node-shapes#record>record</a> shape with one of its fields
*   having the given <I>portname</i>,
*   or have an <A HREF=node-shapes#html>HTML-like label</a>, one of
*   whose components has a <TT>PORT</tt> attribute set to <I>portname</i>.
*   <P>
*   If a compass point is used, it must have the form
*   <TT>"n","ne","e","se","s","sw","w","nw","c","_"</tt>. This modifies the edge
*   placement to aim for the corresponding compass point on the port or,
*   in the second form where no <I>portname</i> is supplied, on the node
*   itself. The compass point "c" specifies the center of the node or port.
*   The compass point "_" specifies that an appropriate side of the port
*   adjacent to the exterior of the node should be used, if such exists.
*   Otherwise, the center is used.
*   If no compass point is used with a portname, the default value is "_".
*   </p><P>
*   </p><P>
*   This attribute can be attached to an edge using the
*   <A HREF=#dheadport>headport</a> and
*   <A HREF=#dtailport>tailport</a> attributes, or as part of the
*   edge description as in
*   <CENTER>
*   <TT>node1:port1 -> node2:port5:nw;</tt>
*   </center>
*   </p><P>
*   Note that it is legal to have a portname the same as one of
*   the compass points. In this case, this reference will be resolved to
*   the port. Thus, if node <TT>A</tt> has a port <TT>w</tt>, then
*   <TT>headport=w</tt> will refer to the port and not the compass point.
*   At present, in this case, there is no way to specify that the compass
*   point should be used.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "portPos";
}
