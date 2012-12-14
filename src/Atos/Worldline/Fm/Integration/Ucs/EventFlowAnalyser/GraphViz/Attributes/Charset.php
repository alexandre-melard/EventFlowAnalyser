<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Specifies the character encoding used when interpreting string input
 *   as a text label. The default value is <TT>"UTF-8"</tt>.
 *   The other legal value is <TT>"iso-8859-1"</tt> or,
 *   equivalently,
 *   <TT>"Latin1"</tt>. The <B>charset</b> attribute is case-insensitive.
 *   Note that if the character encoding used in the input does not
 *   match the <B>charset</b> value, the resulting output may be very strange.
 */
class Charset extends AbstractAttributes
{    
    
    protected $name = "charset";
}
