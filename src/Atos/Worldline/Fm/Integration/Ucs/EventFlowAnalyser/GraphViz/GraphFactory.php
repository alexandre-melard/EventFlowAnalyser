<?php
/**
 * @author alexandre@melard.fr
 *
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz;

use Mylen\GraphViz\Factory\Factory;

use Mylen\GraphViz\Attributes\Color;
use Mylen\GraphViz\Factory\Format;
use Mylen\GraphViz\Factory\GraphFactory as f;

class GraphFactory implements Factory
{
    public static function create($format, $id, $type=null)
    {
        return f::create($format, $id);
    }
}
