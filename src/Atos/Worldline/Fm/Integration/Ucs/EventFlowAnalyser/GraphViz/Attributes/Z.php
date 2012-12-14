<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * <B>Deprecated</b>Use <A HREF=#dpos><B>pos</b></a> attribute, along
 *   with <A HREF=#ddimen><B>dimen</b></a> and/or <A HREF=#ddim><B>dim</b></a>
 *   to specify dimensions.
 *   <P>
 *   Provides z coordinate value for 3D layouts and displays. If the
 *   graph has <A HREF=#ddim><B>dim</b></a> set to 3 (or more),
 *   neato will use a node's <B>z</b> value
 *   for the z coordinate of its initial position if
 *   its <A HREF=#dpos><B>pos</b></a> attribute is also defined.
 *   </p><P>
 *   Even if no <B>z</b> values are specified in the input, it is necessary to
 *   declare a <B>z</b> attribute for nodes, e.g, using <TT>node[z=""]</tt>
 *   in order to get z values on output.
 *   Thus, setting <TT>dim=3</tt> but not declaring <B>z</b> will
 *   cause <TT>neato -Tvrml</tt> to
 *   layout the graph in 3D but project the layout onto the xy-plane
 *   for the rendering. If the <B>z</b> attribute is declared, the final rendering
 *   will be in 3D.
 */
class Z extends AbstractAttributes
{                
    
    protected $name = "z";
}
