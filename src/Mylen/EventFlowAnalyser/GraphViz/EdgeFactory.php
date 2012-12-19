<?php
/**
 * @author alexandre@melard.fr
 *
 */
namespace Mylen\EventFlowAnalyser\GraphViz;

use Mylen\GraphViz\Factory\EdgeFactory as f;

class EdgeFactory
{

    /**
     * 
     * @param $format
     * @param array $list
     * @param $type
     * @return \Mylen\GraphViz\Spring\Neato\Edge|\Mylen\GraphViz\Circular\Circo\Edge|\Mylen\GraphViz\Hierarchical\Dot\Edge|\Mylen\GraphViz\Spring\Fdp\Edge|\Mylen\GraphViz\Spring\Fdp\Sfdp\Edge|\Mylen\GraphViz\Radial\Twopi\Edge
     */
    public static function create($format, $list, $type=null)
    {
        return f::create($format, $list);
    }
}
