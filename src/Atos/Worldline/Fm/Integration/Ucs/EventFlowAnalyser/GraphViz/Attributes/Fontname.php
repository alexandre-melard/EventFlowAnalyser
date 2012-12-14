<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Font used for text. This very much depends on the output format and, for
 *   non-bitmap output such as PostScript or SVG, the availability of the font
 *   when the graph is displayed or printed. As such, it is best to rely on
 *   font faces that are generally available, such as Times-Roman, Helvetica or
 *   Courier.
 *   <P>
 *   If Graphviz was built using the
 *   <A HREF=http://pdx.freedesktop.org/~fontconfig/fontconfig-user.html>fontconfig library</a>, the latter library
 *   will be used to search for the font. However, if the <TT>fontname</tt> string
 *   contains a slash character "/", it is treated as a pathname for the font
 *   file, though font lookup will append the usual font suffixes.
 *   </p><P>
 *   If Graphviz does not use fontconfig, <TT>fontname</tt> will be
 *   considered the name of a Type 1 or True Type font file.
 *   If you specify <TT>fontname=schlbk</tt>, the tool will look for a
 *   file named  <TT>schlbk.ttf</tt> or <TT>schlbk.pfa</tt> or <TT>schlbk.pfb</tt>
 *   in one of the directories specified by
 *   the <A HREF=#dfontpath>fontpath</a> attribute.
 *   The lookup does support various aliases for the common fonts.
 */
class Fontname extends AbstractAttributes
{                
    
    protected $name = "fontname";
}
