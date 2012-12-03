<<<<<<< HEAD
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:07
 * EventOut class type. Barely an Event... For now.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EventOut implements Entity, VisitorHost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var IntegerType
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn", inversedBy="eventOuts")
     * @var EventIn
     */
    private $eventIn;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventFlow", inversedBy="parents")
     */
    private $eventFlow;

    public function accept(VisitorGuest $guest)
    {
        $guest->visit($this);
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
     * 
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->event->getType();
    }

    public function getEventIn()
    {
        return $this->eventIn;
    }

    public function setEventIn(EventIn $eventIn)
    {
        $this->eventIn = $eventIn;
    }

    public function getEventFlow()
    {
        return $this->eventFlow;
    }

    public function setEventFlow(EventFlow $eventFlow)
    {
        $this->eventFlow = $eventFlow;
    }

}
