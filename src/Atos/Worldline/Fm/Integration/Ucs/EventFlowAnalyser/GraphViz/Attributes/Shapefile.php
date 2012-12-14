<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * (Deprecated) If defined, shapefile specifies a file containing user-supplied node content.
 *   The <A HREF=#dshape><B>shape</b></a> of the node is set to box.
 *   The image in the shapefile must be
 *   rectangular. The image formats supported as well as the precise semantics of
 *   how the file is used depends on the
 *   <A HREF="output-formats">output format</a>.  For further details, see
 *   <A HREF=output-formats#dimage_fmts>Image Formats</a> and
 *   <A HREF=http://www.graphviz.org/wiki/how-create-custom-shapes#ext_image>External PostScript files</a>.
 *   <P>
 *   There is one exception to this usage.
 *   If <B>shape</b> is set to "epsf", shapefile gives
 *   a filename containing a definition of the node in PostScript.
 *   The graphics defined must be contain all of the
 *   node content, including any desired boundaries.
 *   For further details, see
 *   <A HREF=http://www.graphviz.org/wiki/how-create-custom-shapes#ext_ps>
 *   External PostScript files</a>.
 */
class Shapefile extends AbstractAttributes
{                
    
    protected $name = "shapefile";
}
