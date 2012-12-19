<?php
/**
 * @author alexandre@melard.fr
 *
 */
namespace Mylen\EventFlowAnalyser\GraphViz;

use Mylen\GraphViz\Factory\SubGraphFactory as f;

class SubGraphFactory
{

    /**
     * 
     * @param type $format
     * @param type $id
     * @param type $type
     * @return \Mylen\GraphViz\SubGraph
     */
    public static function create($format, $id, $type=null)
    {
        return f::create($format, $id);
    }
}
