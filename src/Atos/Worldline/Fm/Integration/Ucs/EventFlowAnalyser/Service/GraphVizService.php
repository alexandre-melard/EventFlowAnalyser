<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Mylen\GraphViz\Attributes\Id;

use Mylen\GraphViz\Attributes\Rect;
use Mylen\GraphViz\Attributes\Bb;
use Mylen\GraphViz\Attributes\Viewport;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\ClusterFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;
use Mylen\GraphViz\Attributes\Fontsize;
use Alom\Graphviz\BaseInstruction;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\SubGraphFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\EdgeFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\NodeFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Type;
use Mylen\GraphViz\Factory\Format;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\GraphFactory;
use Mylen\GraphViz\Attributes\URL;
use Mylen\GraphViz\Attributes\Shape;
use Mylen\GraphViz\Attributes\Color;
use Mylen\GraphViz\Attributes\Label;
use Mylen\GraphViz\Attributes\Fixedsize;
use Mylen\GraphViz\Attributes\Height;
use Mylen\GraphViz\Attributes\Width;
use Mylen\GraphViz\Attributes\Style;
use Mylen\GraphViz\Attributes\Rankdir;
use Mylen\GraphViz\Attributes\Overlap;
use Mylen\GraphViz\Attributes\Bgcolor;
use Mylen\GraphViz\Attributes\Splines;
use Mylen\GraphViz\Attributes\Nodesep;
use Mylen\GraphViz\Attributes\Size;
use Mylen\GraphViz\Attributes\Sep;
use Mylen\GraphViz\Types\AddDoubleType;

use Mylen\GraphViz\Hierarchical\Dot\SubGraph;
use Mylen\GraphViz\Hierarchical\Dot\Edge;
use Mylen\GraphViz\Hierarchical\Dot\Node;
use Mylen\GraphViz\Hierarchical\Dot\Graph;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;

class GraphVizService
{
    /**
     * generate GraphViz graph from event
     * @param Event $event
     * @return string
     */
    public function generateEventGraph(Event $event)
    {
        $parents = $event->getParents();
        $children = $event->getChildren();

        $graph = GraphFactory::create(Format::DOT, $event->getShortEvent())->setRankdir(new Rankdir('TB'))->setBgcolor(new Bgcolor('white'));
        $graph->setId(new Id('viewport'));
        
        $eventNode = NodeFactory::create(Format::DOT, $event->getShortEvent(), Type::EVENT);

        $subChildren = SubGraphFactory::create(Format::DOT, 'children')->setColor(new Color('invis'));

        foreach ($children as $child) {
            $childNode = NodeFactory::create(Format::DOT, $child->getEvent()->getShortEvent(), Type::CHILD)
                    ->setURL(new URL($child->getEvent()->getType()));

            $subChildren->append($childNode);

            $subChildren->append(
                            EdgeFactory::create(Format::DOT, array($eventNode->getId(), $childNode->getId())));
        }
        $subChildren->append(
                        NodeFactory::create(Format::DOT, 'childAnchor', Type::INVIS));

        $subParents = SubGraphFactory::create(Format::DOT, 'parents')->setColor(new Color('invis'));

        foreach ($parents as $parent) {
            $parentEventNode = NodeFactory::create(Format::DOT, $parent->getEvent()->getShortEvent(), Type::ANCESTOR)
                    ->setURL(new URL($parent->getEvent()->getType()));
            $subParents->append($parentEventNode);
            $subParents->append(EdgeFactory::create(Format::DOT, array($parentEventNode->getId(), $eventNode->getId())));
        }
        $subParents->append(NodeFactory::create(Format::DOT, 'parentdAnchor', Type::INVIS));

        $graph->append($subParents);
        $graph->append($eventNode);
        $graph->append($subChildren);

        return $graph->render();
    }
    
    /**
     * generate GraphViz graph from event
     * @param Event $event
     * @return string
     */
    public function generateProcessGraph(Event $event)
    {
        $parents = $event->getParents();
        $children = $event->getChildren();

        $graph = GraphFactory::create(Format::DOT, $event->getShortEvent())
        ->setId(new Id('viewport'))
        ->setSplines(new Splines('false'))
        ->setRankdir(new Rankdir('TB'))
        ->setBgcolor(new Bgcolor('white'));

        $eventNode = NodeFactory::create(Format::DOT, $event->getShortEvent(), Type::EVENT);
        
        $subParents = SubGraphFactory::create(Format::DOT, 'parents')->setColor(new Color('invis'));

        $processes = array();
        $edges = array();
        foreach ($parents as $parent) {
            /* $parent EventOut */
            $parentEventNode = NodeFactory::create(Format::DOT, $parent->getEvent()->getShortEvent(), Type::ANCESTOR)
            ->setURL(new URL($parent->getEvent()->getType()));
            $parentProcessNode = NodeFactory::create(Format::DOT, $parent->getParser()->getDocument()->getName(), Type::PROCESS);
            
            $subParents->append($parentEventNode);

            if (!isset($processes[$parentProcessNode->getId()])) {
                $processes[$parentProcessNode->getId()] = 1;                
                $subParents->append($parentProcessNode);
            }            
            if (!isset($edges[$parentProcessNode->getId() . $eventNode->getId()])) {
                $edges[$parentProcessNode->getId() . $eventNode->getId()] = 1;
                $subParents->append(EdgeFactory::create(Format::DOT, array($parentProcessNode->getId(), $eventNode->getId())));
            }
            if (!isset($edges[$parentEventNode->getId() . $parentProcessNode->getId()])) {
                $edges[$parentEventNode->getId() . $parentProcessNode->getId()] = 1;
                $subParents->append(EdgeFactory::create(Format::DOT, array($parentEventNode->getId(), $parentProcessNode->getId())));
            }
            
        }
        $subParents->append(NodeFactory::create(Format::DOT, 'parentdAnchor', Type::INVIS));
        
        $subChildren = SubGraphFactory::create(Format::DOT, 'children')->setColor(new Color('invis'));

        foreach ($children as $child) {
            $childNode = NodeFactory::create(Format::DOT, $child->getEvent()->getShortEvent(), Type::CHILD)
                    ->setURL(new URL($child->getEvent()->getType()));
            $childProcessNode = NodeFactory::create(Format::DOT, $child->getEventIn()->getParser()->getDocument()->getName(), Type::PROCESS);
            
            $subChildren->append($childNode);
            
            if (!isset($processes[$childProcessNode->getId()])) {
                $processes[$childProcessNode->getId()] = 1;
                $subChildren->append($childProcessNode);
            }
            if (!isset($edges[$childProcessNode->getId() . $childNode->getId()])) {
                $edges[$childProcessNode->getId() . $childNode->getId()] = 1;
                $subChildren->append(EdgeFactory::create(Format::DOT, array($childProcessNode->getId(), $childNode->getId())));
            }
            if (!isset($edges[$eventNode->getId() . $childProcessNode->getId()])) {
                $edges[$eventNode->getId() . $childProcessNode->getId()] = 1;
                $subChildren->append(EdgeFactory::create(Format::DOT, array($eventNode->getId(), $childProcessNode->getId())));
            }
            
        }
        $subChildren->append(NodeFactory::create(Format::DOT, 'childAnchor', Type::INVIS));

        $graph->append($subParents);
        $graph->append($eventNode);
        $graph->append($subChildren);

        return $graph->render();
    }
    
    
    /**
     * generate GraphViz graph from parser
     * @param Parser parser
     * @return \Alom\Graphviz\Subgraph
     */
    public function computeProcessGraph(Parser $parser)
    {
        $subGraph = ClusterFactory::create(Format::DOT, $parser->getDocument()->getId());
        $subGraph
        ->setLabel(new Label($parser->getDocument()->getName()))
        ->setStyle(new Style('dashed'))
        ;
        
        $eventIns = $parser->getEventIns();
        foreach ($eventIns as $eventIn) {
            /* @var $eventIn EventIn */
            $in = NodeFactory::create(Format::DOT, $eventIn->getEvent()->getShortEvent(), Type::EVENT);
            $subGraph->append($in);
            foreach ($eventIn->getEventOuts() as $eventOut) {
                /* @var $eventOut EventOut */
                $out = NodeFactory::create(Format::DOT, $eventOut->getEvent()->getShortEvent(), Type::EVENT);
                $subGraph->append($out);
                $subGraph->append(
                                EdgeFactory::create(
                                Format::DOT, 
                                array(
                                        $in->getId(),
                                        $out->getId()
                                )
                            )
                        );
            }
        }

        return $subGraph;
    }

    /**
     * generate GraphViz graph from project
     * @param Project project
     * @return \Alom\Graphviz\Graph
     */
    public function computeProjectGraph(Project $project)
    {
        $graph = GraphFactory::create(Format::DOT, $project->getName());
        $graph->setId(new Id('viewport'));
        $documents = $project->getDocuments();
        foreach ($documents as $document) {
            $graph->append($this->computeProcessGraph($document->getParser()));
        }        
        return $graph;
    }

    /**
     * 
     * @param Project $project
     * @return string the generated GraphViz for the project
     */
    public function generateProjectGraph(Project $project) 
    {
        return $this->computeProjectGraph($project)->render();
    }
}
