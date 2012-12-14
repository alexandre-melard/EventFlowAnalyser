<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\AddDoubleType;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\StringType;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\AddDouble;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Sep;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types\ArrowType;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Len;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Ranksep;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Scale;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Rotate;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Weight;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Nodesep;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Arrowhead;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Splines;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Style;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Color;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Edge;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Node;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Bgcolor;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Size;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fillcolor;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Graph;

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
        ->setSep(new Sep(new AddDoubleType('+1.5,1.0')))
        ->setRanksep(new Ranksep(new StringType(1.5)))
        ->setSize(new Size(new StringType('200pt')))
        ->setScale(new Scale(new StringType('2 2')))
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
                
        $trm2opm = Edge::create(array($trm->getId(), $opm->getId()));
        $trm2opm
            ->setLen(new Len(new StringType(2)))
            ->setArrowhead(new Arrowhead(ArrowType::create(ArrowType::CROW)));
        
        
        $trm2pom = Edge::create(array($trm->getId(), $pom->getId()));
        $trm2pom->setLen(new Len(new StringType(2)));
        
        $pom2opm = Edge::create(array($pom->getId(), $opm->getId()));
        $pom2opm->setLen(new Len(new StringType(2)));
        
        
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
