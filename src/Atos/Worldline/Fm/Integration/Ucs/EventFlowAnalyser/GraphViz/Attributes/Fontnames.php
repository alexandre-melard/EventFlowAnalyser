<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Allows user control of how basic fontnames are represented in SVG output.
 *   If <TT>fontnames</tt> is undefined or <TT>"svg"</tt>,
 *   the output will try to use known SVG fontnames. For example, the
 *   default font  <TT>"Times-Roman"</tt> will be mapped to the
 *   basic SVG font <TT>"serif"</tt>. This can be overridden by setting
 *   <TT>fontnames</tt> to  <TT>"ps"</tt> or  <TT>"gd"</tt>.
 *   In the former case, known PostScript font names such as
 *   <TT>"Times-Roman"</tt> will be used in the output.
 *   In the latter case, the fontconfig font conventions
 *   are used. Thus, <TT>"Times-Roman"</tt> would be treated as
 *   <TT>"Nimbus Roman No9 L"</tt>. These last two options are useful
 *   with SVG viewers that support these richer fontname spaces.
 */
class Fontnames extends AbstractAttributes
{                
    
    protected $name = "fontnames";
}
