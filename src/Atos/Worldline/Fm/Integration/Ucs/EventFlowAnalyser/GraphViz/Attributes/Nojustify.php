<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * By default, the justification of multi-line labels is done within the
 *   largest context that makes sense. Thus, in the label of a polygonal
 *   node, a left-justified line will align with the left side of the node
 *   (shifted by the prescribed <A HREF=#dmargin>margin</a>).
 *   In record nodes, left-justified
 *   line will line up with the left side of the enclosing column of fields.
 *   If <B>nojustify</b> is <TT>"true"</tt>, multi-line labels will be justified
 *   in the context of itself. For example, if the attribute is set,
 *   the first label line is long, and the second is shorter and left-justified,
 *   the second will align with the left-most character in the first line,
 *   regardless of  how large the node might be.
 */
class Nojustify extends AbstractAttributes
{                
    
    protected $name = "nojustify";
}
