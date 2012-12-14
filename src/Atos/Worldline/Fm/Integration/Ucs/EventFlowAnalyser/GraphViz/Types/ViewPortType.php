<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* "%lf,%lf,%lf,%lf,%lf" or  "%lf,%lf,%lf,'%s'"
*   <P>
*   The viewPort <TT>W,H,Z,x,y</tt> or <TT>W,H,Z,N</tt>
*   specifies a viewport for the final image. The pair (W,H) gives the
*   dimensions (width and height) of the final image, in
*   <A HREF=#points>points</a>.
*   The optional Z is the zoom factor, i.e., the image in the original layout will be
*   W/Z by H/Z points in size. By default, Z is 1.
*   The optional last part is either a pair (x,y) giving a position in the original layout of the
*   graph, in
*   <A HREF=#points>points</a>, of the center of the viewport, or the name N
*   of a node whose center should used as the focus.
*   By default, the focus is the center of the graph bounding box, i.e.,
*   (bbx/2,bby/2), where "bbx,bby" is the
*   value of the bounding box attribute <A HREF=#a:bb>bb</a>.
*   </p><P>
*   Sample values: <TT>50,50,.5,'2.8 BSD' or <TT>100,100,2,450,300</tt>.
*   The first will take the 100x100 point square centered on the node <TT>2.8 BSD</tt>
*   and scale it down by 0.5, yielding a 50x50 point final image.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "viewPort";
}
