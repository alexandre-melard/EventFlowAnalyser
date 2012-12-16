<?php
/**
 * @author alexandre@melard.fr
 *
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz;

use Mylen\GraphViz\Factory\Format;
use Mylen\GraphViz\Factory\SubGraphFactory as f;

class SubGraphFactory
{

    public static function create($format, $id, $type=null)
    {
        return f::create($format, $id);
    }
}
