<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Alom\Graphviz\Graph;
use Alom\Graphviz\Subgraph;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\ClusterFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\EdgeFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\GraphFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\NodeFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\SubGraphFactory;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Type;
use Mylen\GraphViz\Attributes\Bgcolor;
use Mylen\GraphViz\Attributes\Color;
use Mylen\GraphViz\Attributes\Id;
use Mylen\GraphViz\Attributes\Label;
use Mylen\GraphViz\Attributes\Rankdir;
use Mylen\GraphViz\Attributes\Splines;
use Mylen\GraphViz\Attributes\Style;
use Mylen\GraphViz\Attributes\URL;
use Mylen\GraphViz\Factory\Format;

class GraphVizService
{

    protected $command = "";
    /**
     * generate GraphViz graph from event
     * @param Event $event
     * @return string
     */
    public function generateEventGraph(Event $event, $format=null, $format=null, $output=null, $file=null)
    {
        $parents = $event->getParents();
        $children = $event->getChildren();

        $graph = GraphFactory::create(
                $format, 
                $event->getShortEvent()
                );
        $graph
        ->setRankdir(new Rankdir('TB'))
        ->setBgcolor(new Bgcolor('white'))
        ->setId(new Id('viewport'))
        ;
        
        $eventNode = NodeFactory::create($format, $event->getShortEvent(), Type::EVENT);
        $graph->append($eventNode);

        if (null !== $children) {
            $subChildren = SubGraphFactory::create($format, 'children')->setColor(new Color('invis'));

            foreach ($children as $child) {
                $childNode = NodeFactory::create($format, $child->getEvent()->getShortEvent(), Type::CHILD)
                        ->setURL(new URL($child->getEvent()->getType()));

                $subChildren->append($childNode);

                $subChildren->append(
                                EdgeFactory::create($format, array($eventNode->getId(), $childNode->getId())));
            }
            $subChildren->append(NodeFactory::create($format, 'childAnchor', Type::INVIS));
            $graph->append($subChildren);            
        }

        if (null !== $parents) {
            $subParents = SubGraphFactory::create($format, 'parents')->setColor(new Color('invis'));

            foreach ($parents as $parent) {
                $parentEventNode = NodeFactory::create($format, $parent->getEvent()->getShortEvent(), Type::ANCESTOR)
                        ->setURL(new URL($parent->getEvent()->getType()));
                $subParents->append($parentEventNode);
                $subParents->append(EdgeFactory::create($format, array($parentEventNode->getId(), $eventNode->getId())));
            }
            $subParents->append(NodeFactory::create($format, 'parentdAnchor', Type::INVIS));
            $graph->append($subParents);
        }
        $graph->setCommand($this->command);
        $graph->setFormat($format);
        $graph->setOutput($output);
        $graph->setFile($file);
        return $graph->render();
    }
    
    /**
     * generate GraphViz graph from event
     * @param Event $event
     * @return string
     */
    public function generateProcessGraph(Event $event, $format=null, $output=null, $file=null)
    {
        $parents = $event->getParents();
        $children = $event->getChildren();

        $graph = GraphFactory::create(Format::DOT, $event->getShortEvent())
        ->setId(new Id('viewport'))
        ->setSplines(new Splines('false'))
        ->setRankdir(new Rankdir('TB'))
        ->setBgcolor(new Bgcolor('white'));

        $eventNode = NodeFactory::create(Format::DOT, $event->getShortEvent(), Type::EVENT);
        $graph->append($eventNode);
        
        $processes = array();
        $edges = array();
        if (null !== $parents) {
            $subParents = SubGraphFactory::create(Format::DOT, 'parents')->setColor(new Color('invis'));
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
            $graph->append($subParents);
        }

        if (null !== $children) {
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
            $graph->append($subChildren);
        }

        $graph->setCommand($this->command)->setFormat($format)->setOutput($output);
        $graph->setFile($file);

        return $graph->render();
    }
    
    
    /**
     * generate GraphViz graph from parser
     * @param Parser parser
     * @return Subgraph
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
     * @return Graph
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
    public function generateProjectGraph(Project $project, $format=null, $output=null, $file=null) 
    {
        return $this
                ->computeProjectGraph($project)
                ->setCommand($this->command)
                ->setFormat($format)
                ->setOutput($output)
                ->setFile($file)
                ->render();
    }

    /**
     * @param Project $project
     * @param string $what
     * @return string the generated GraphViz 
     */
    public function getGraph(Project $project, $what)
    {
        return file_get_contents($project->getPath() . DIRECTORY_SEPARATOR . 'graphs' . DIRECTORY_SEPARATOR . $what  .'.svg');
    }
    
    /**
     * 
     * @param Event $event
     * @return string the generated GraphViz for the event
     */
    public function getProcessGraph(Event $event) 
    {
        return $this->getGraph($event->getProject(), $event->getType());
    }

    /**
     * 
     * @param Project $project
     * @return string the generated GraphViz for the project
     */
    public function getProjectGraph(Project $project) 
    {
        return $this->getGraph($project, $project->getName());
    }
    
    /**
     * return dot command
     * @param type $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }
}
