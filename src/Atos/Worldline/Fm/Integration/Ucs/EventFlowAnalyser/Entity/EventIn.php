<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:07
 * EventIn class type. An event aggregates 0..* EventOut.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EventIn extends Entity implements VisitorHost
{
    /**
     * One to Many type 
     * @ORM\ManyToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut")
     */
    protected $eventOuts;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event")
     * @var Event
     */
    protected $event;

    public function __construct()
    {
        $this->eventOuts = array();
    }
    
    public function accept(VisitorGuest $guest)
    {
        foreach ($this->getEventOuts() as $eventOut) {
            /* @var $eventOut EventOut */
            $eventOut->accept($guest);
        }
        $this->event->accept($guest);
        $guest->visit($this);
    }
    
    public function addEventOut(EventOut $event)
    {
        if (!empty($event)) {
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
     * @return EventOut
     */
    public function getEventOuts()
    {
        return $this->eventOuts;
    }

    public function setEventOuts($eventOuts)
    {
        $this->eventOuts = $eventOuts;
    }

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
    
}
