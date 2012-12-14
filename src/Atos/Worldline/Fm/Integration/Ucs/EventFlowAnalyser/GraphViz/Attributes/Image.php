<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Allows the graph author to provide an id for graph objects which is to be included in the output.
 *   Normal "N", "E", "G" substitutions are applied.
 *   If provided, it is the reponsiblity of the provider to keep
 *   its values sufficiently unique for its intended downstream use.
 *   Note, in particular, that "E" does not provide a unique id for multi-edges.
 *   If no id attribute is provided, then a unique internal id is used. However, 
 *   this value is unpredictable by the graph writer.
 *   An externally provided id is not used internally.
 *   <P>
 *   If the graph provides an id attribute, this will be used as a prefix for
 *   internally generated attributes. By making these distinct, the user
 *   can include multiple image maps in the same document.
 */
class Image extends AbstractAttributes
{                
    
    protected $id;
    
    /**
 * Gives the name of a file containing an image to be displayed inside
 *   a node. The image file must be in one of the recognized 
 *   <A HREF=output-formats#dimage_fmts>formats</a>,
 *   typically JPEG, PNG, GIF, BMP, SVG or Postscript, and be able to be converted
 *   into the desired output format.
 *   <P>
 *   The file must contain the image size information. This is usually trivially
 *   true for the bitmap formats. For PostScript, the file must contain a
 *   line starting with <TT>%%BoundingBox: </tt> followed by four integers
 *   specifying the lower left x and y coordinates and the upper right x and y
 *   coordinates of the bounding box for the image, the coordinates being in
 *   points. An SVG image file must contain <TT>width</tt> and <TT>height</tt>
 *   attributes, typically as part of the <TT>svg</tt> element.
 *   The values for these should have the form of a floating point number,
 *   followed by optional units, e.g., <TT>width="76pt"</tt>. 
 *   Recognized units are <TT>in</tt>, <TT>px</tt>,
 *   <TT>pc</tt>, <TT>pt</tt>, <TT>cm</tt> and <TT>mm</tt> for inches, pixels,
 *   picas, points, centimeters and millimeters, respectively.
 *   The default unit is points.
 *   </p><P>
 *   Unlike with the <A HREF=#dshapefile>shapefile</a> attribute,
 *   the image is treated as node
 *   content rather than the entire node. In particular, an image can
 *   be contained in a node of any shape, not just a rectangle.
 */
    protected $name = "image";
}
