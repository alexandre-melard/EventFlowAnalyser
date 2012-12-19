<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:07
 * EventIn class type. An event aggregates 0..* EventOut.
 */
namespace Mylen\EventFlowAnalyser\Entity;

use Mylen\EventFlowAnalyser\Patterns\VisitorHost;
use Mylen\EventFlowAnalyser\Patterns\VisitorGuest;
use Mylen\EventFlowAnalyser\Entity\Parser;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EventIn implements Entity, VisitorHost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var IntegerType
     */
    private $id;

    /**
     * One to Many type 
     * @ORM\OneToMany(targetEntity="Mylen\EventFlowAnalyser\Entity\EventOut", mappedBy="eventIn")
     */
    private $eventOuts;

    /**
     * @ORM\ManyToOne(targetEntity="Mylen\EventFlowAnalyser\Entity\Event")
     * @var Event
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="Mylen\EventFlowAnalyser\Entity\Parser", inversedBy="eventIns")
     * @var Parser
     */
    private $parser;

    public function accept(VisitorGuest $guest)
    {
        if(isset($this->eventOuts)) {
            foreach ($this->eventOuts as $eventOut) {
                /* @var $eventOut EventOut */
                $eventOut->accept($guest);
            }
        }
        $guest->visit($this);
    }

    public function addEventOut(EventOut $event)
    {
        if (!empty($event)) {
            if (!isset($this->eventOuts)) {
                $this->eventOuts = array();
            }
            array_push($this->eventOuts, $event);
        }
    }

    public function removeEventOut(EventOut $event)
    {
        if (!empty($event)) {
            unset($this->eventOuts[$event]);
        }
    }

    /**
     * @return IntegerType
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     *
     * @param IntegerType $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /** 
     * @return EventOut
     */
    public function getEventOuts()
    {
        if (!isset($this->eventOuts)) {
            $this->eventOuts = array();
        }
        return $this->eventOuts;
    }

    public function setEventOuts($eventOuts)
    {
        $this->eventOuts = $eventOuts;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getType()
    {
        return $this->event->getType();
    }

    /**
     * 
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }

}
