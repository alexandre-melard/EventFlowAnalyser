<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * This attribute specifies a color scheme namespace. If defined, it specifies
 *   the context for interpreting color names. In particular, if a
 *   <A HREF=#kcolor>color</a> value has form <TT>"xxx"</tt> or <TT>"//xxx"</tt>,
 *   then the
 *   color <TT>xxx</tt> will be evaluated according to the current color scheme.
 *   If no color scheme is set, the standard X11 naming is used.
 *   For example, if <TT>colorscheme=bugn9</tt>, then <TT>color=7</tt>
 *   is interpreted as <TT>"/bugn9/7"</tt>.
 */
class Colorscheme extends AbstractAttributes
{                
    
    protected $name = "colorscheme";
}
