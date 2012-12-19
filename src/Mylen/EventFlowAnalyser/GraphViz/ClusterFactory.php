<?php
/**
 * @author alexandre@melard.fr
 *
 */
namespace Mylen\EventFlowAnalyser\GraphViz;

use Mylen\GraphViz\Factory\ClusterFactory as f;

class ClusterFactory
{

    public static function create($format, $id, $type=null)
    {
        return f::create($format, $id);
    }
}
