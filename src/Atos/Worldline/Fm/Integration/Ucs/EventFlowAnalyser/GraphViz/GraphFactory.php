<?php
/**
 * @author alexandre@melard.fr
 *
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz;

use Mylen\GraphViz\Factory\Factory;

use Mylen\GraphViz\Factory\GraphFactory as f;

class GraphFactory implements Factory
{
    public static function create($format, $id, $type=null)
    {
        /* @var $graph \Mylen\GraphViz\Graph */
        $graph = f::create($format, $id);
        $graph->setDpi(new \Mylen\GraphViz\Attributes\Dpi('600'));
        return $graph;
    }
}
