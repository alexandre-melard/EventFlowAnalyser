<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes;


/**
 * Justification for cluster labels. If "r", the label
 *   is right-justified within bounding rectangle; if "l", left-justified;
 *   else the label is centered.
 *   Note that a subgraph inherits attributes from its parent. Thus, if
 *   the root graph sets <B>labeljust</b> to "l", the subgraph inherits
 *   this value.
 */
class Labeljust extends AbstractAttributes
{                
    
    protected $name = "labeljust";
}
