<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Specifies a list of directories in which to look for image files as specified by the
 *   <a href="#dimage">image</a> attribute or using the <TT>IMG</tt> element in
 *   <a href="node-shapes#html">HTML-like labels</a>.
 *   The string should be a list of (absolute or relative) pathnames, each separated by
 *   a semicolon (for Windows) or a colon (all other OS). 
 *   The first directory in which a file of the given name is found will be used to
 *   load the image. If <tt>imagepath</tt> is not set, relative pathnames for the image
 *   file will be interpreted with respect to the current working directory.
 */
class Imagepath extends AbstractAttributes
{                
    
    protected $name = "imagepath";
}
