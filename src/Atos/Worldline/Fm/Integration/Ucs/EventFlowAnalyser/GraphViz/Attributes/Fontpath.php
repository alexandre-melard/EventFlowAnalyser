<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Directory list used by libgd to search for bitmap fonts if Graphviz
 *   was not built with the fontconfig library.
 *   If <B>fontpath</b> is not set, the environment
 *   variable <TT>DOTFONTPATH</tt> is checked.
 *   If that is not set, <TT>GDFONTPATH</tt> is checked.
 *   If not set, libgd uses its compiled-in font path.
 *   Note that fontpath is an attribute of the root graph.
 */
class Fontpath extends AbstractAttributes
{                
    
    protected $name = "fontpath";
}
