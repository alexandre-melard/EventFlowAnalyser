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
class EventOut extends Entity implements VisitorHost
{
    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event")
     */
    protected $event;
    
    public function accept(VisitorGuest $guest)
    {
        $this->event->accept($guest);
        $guest->visit($this);
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
