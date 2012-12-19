<?php
/**
 * @author alexandre@melard.fr
 *
 */
namespace Mylen\EventFlowAnalyser\GraphViz;

use Mylen\GraphViz\Attributes\Fontsize;

use Mylen\GraphViz\Factory\Format;
use Mylen\GraphViz\Attributes\Color;
use Mylen\GraphViz\Attributes\Shape;
use Mylen\GraphViz\Attributes\Style;
use Mylen\GraphViz\Factory\NodeFactory as f;

class NodeFactory
{

    public static function create($format, $id, $type=null)
    {
        $node = f::create($format, $id)
                    ->setFontsize(new Fontsize('11.0'))
                    ->setShape(new Shape('box'))
                    ->setStyle(new Style('rounded'));
        
        switch ($type) {
            case Type::ANCESTOR:
                return $node->setColor(new Color('purple'));
            case Type::CHILD:
                return $node->setColor(new Color('green'));
            case Type::EVENT:
                return $node->setColor(new Color('orange'));
            case Type::PROCESS:
                return $node->setStyle(new Style('dashed'));
            case Type::INVIS:
                return $node->invisible();
            default:
                return $node;
        }
    }
}
