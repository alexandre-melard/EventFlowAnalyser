<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* specifies a list of layers defined by the <A HREF=#alayers>layers</a> attribute.
*   It consists of a list of layer intervals separated by any collection of characters from
*   the <A HREF=#alayerlistsep>layerlistsep</a> attribute.
*   Each layer interval is specified as either a
*   layerId or a layerId<B>s</b>layerId<BR />, where layerId = "all",
*   a decimal integer or a <A HREF=#alayer>layer</a> name.
*   (An integer i corresponds to layer i, layers being numbered from 1.)
*   The string <B>s</b> consists of 1 or more separator characters specified
*   by the <A HREF=#alayersep>layersep</a> attribute.
*   <P>
*   Thus, assuming the default values for <A HREF=#alayersep>layersep</a>
*   and <A HREF=#alayerlistsep>layerlistsep</a>, if <TT>layers="a:b:c:d:e:f:g:h"</tt>, the
*   layerRange string <TT>layers="a:b,d,f:all"</tt> would denote the layers
*   <TT>a b d f g h"</tt>.
*/
class AttributeType extends AbstractAttributeType
{
    protected $name = "layerRange";
}
