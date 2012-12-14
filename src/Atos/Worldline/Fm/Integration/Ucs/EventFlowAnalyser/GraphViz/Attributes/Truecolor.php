<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * If set explicitly to true or false, the value determines whether or not
 *   internal bitmap rendering relies on a truecolor color model or uses
 *   a color palette.
 *   If the attribute is unset, truecolor is not used
 *   unless there is a <A HREF=#dshapefile>shapefile</a> property
 *   for some node in the graph.
 *   The output model will use the input model when possible.
 *   <P>
 *   Use of color palettes results in less memory usage during creation of the
 *   bitmaps and smaller output files.
 *   </p><P>
 *   Usually, the only time it is necessary to specify the truecolor model
 *   is if the graph uses more than 256 colors.
 *   However, if one uses <A HREF=#dbgcolor>bgcolor</a>=transparent with
 *   a color palette, font
 *   antialiasing can show up as a fuzzy white area around characters.
 *   Using <B>truecolor</b>=true avoids this problem.
 */
class Truecolor extends AbstractAttributes
{                
    
    protected $name = "truecolor";
}
