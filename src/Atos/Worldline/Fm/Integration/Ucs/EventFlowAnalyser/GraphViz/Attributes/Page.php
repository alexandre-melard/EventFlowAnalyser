<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Width and height of output pages, in inches. If only a single value
 *   is given, this is used for both the width and height.
 *   <P>
 *   If this is set and is
 *   smaller than the size of the layout, a rectangular array of pages of
 *   the specified page size is overlaid on the layout, with origins
 *   aligned in the lower-left corner, thereby partitioning the layout
 *   into pages. The pages are then produced one at a time, in
 *   <A HREF=#dpagedir>pagedir</a> order.
 *   </p><P>
 *   At present, this only works for PostScript output. For other types of
 *   output, one should use another tool to split the output into multiple
 *   output files. Or use the <A HREF=#dviewport>viewport</a> to generate
 *   multiple files.
 */
class Page extends AbstractAttributes
{                
    
    protected $name = "page";
}
