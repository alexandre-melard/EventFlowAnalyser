<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Mylen\GraphViz\Attributes\Rankdir;

use Mylen\GraphViz\Hierarchical\Dot\Graph;
use Mylen\GraphViz\Hierarchical\Dot\Edge;
use Mylen\GraphViz\Hierarchical\Dot\Node;

use Mylen\GraphViz\Types\AddDoubleType;
use Mylen\GraphViz\Types\StringType;
use Mylen\GraphViz\Types\AddDouble;
use Mylen\GraphViz\Attributes\Sep;
use Mylen\GraphViz\Types\ArrowType;
use Mylen\GraphViz\Attributes\Len;
use Mylen\GraphViz\Attributes\Ranksep;
use Mylen\GraphViz\Attributes\Scale;
use Mylen\GraphViz\Attributes\Rotate;
use Mylen\GraphViz\Attributes\Weight;
use Mylen\GraphViz\Attributes\Nodesep;
use Mylen\GraphViz\Attributes\Arrowhead;
use Mylen\GraphViz\Attributes\Splines;
use Mylen\GraphViz\Attributes\Style;
use Mylen\GraphViz\Attributes\Color;
use Mylen\GraphViz\Attributes\Bgcolor;
use Mylen\GraphViz\Attributes\Size;
use Mylen\GraphViz\Attributes\Fillcolor; 

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     * @Template
     */
    public function indexAction()
    {
        $graph = new Graph('G');
        $graph
        ->setRankdir(new Rankdir(new StringType('LR')))
//         ->setSep(new Sep(new AddDoubleType('+1.5')))
        ->setSize(new Size(new StringType('200pt')))
        ->setNodesep(new Nodesep(new StringType('1.5')))
        ->setSplines(new Splines(new StringType('ortho')))
        ->setBgcolor(new Bgcolor(new StringType('white')));
        
        $trm = new Node('trm');
        $trm->setStyle(new Style(new StringType('filled')))
            ->setFillcolor(new Fillcolor(new StringType('red')));
        $opm = new Node('opm');
        $opm->setColor(new Color(new StringType('purple')));
        
        $pom = new Node('pom');
        $pom->setStyle(new Style(new StringType('filled')))
        ->setFillcolor(new Fillcolor(new StringType('green')));
                
        $trm2opm = new Edge(array($trm->getId(), $opm->getId()));
        $trm2opm
//             ->setLen(new Len(new StringType(2)))
            ->setArrowhead(new Arrowhead(ArrowType::create(ArrowType::CROW)));
        
        
        $trm2pom = new Edge(array($trm->getId(), $pom->getId()));
//         $trm2pom->setLen(new Len(new StringType(2)));
        
        $pom2opm = new Edge(array($pom->getId(), $opm->getId()));
//         $pom2opm->setLen(new Len(new StringType(2)));
        
        
        $graph
            ->append($trm)
            ->append($opm)
            ->append($pom)
            ->append($trm2opm)
            ->append($trm2pom)
            ->append($pom2opm);
            
        return array(
            'title' => 'Welcome',
            'graph' => $graph->render(),
        );
    }
}
