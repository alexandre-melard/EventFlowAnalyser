<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:04
 * EventFlow class represents an Event along with the parent events and its children events.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EventFlow extends Entity implements VisitorHost
{
    /**
     * @ORM\OneToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event")
     */
    protected $event;

    /**
     * One to Many type TODO : check if join tables are necessary
     * @ORM\ManyToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut")
     */
    protected $parents;

    /**
     * One to Many type TODO : check if join tables are necessary
     * @ORM\ManyToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn")
     */
    protected $children;

    /**
     * @param $event Event
     * @param $parents EventIn[]
     * @param $children EventOut[]
     */
    public function __construct($event, $parents, $children)
    {
        $this->event = $event;
        $this->parents = $parents;
        $this->children = $children;
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

    /**
     * 
     * @return EventIn[]
     */
    public function getParents()
    {
        return $this->parents;
    }

    public function setParents($parents)
    {
        $this->parents = $parents;
    }

    /**
     * 
     * @return EventOut[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function getId()
    {
        return $this->id;
    }
    
    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        foreach ($this->children as $child) {
            $child->accept($guest);
        }
        foreach ($this->parents as $parent) {
            $parent->accept($guest);
        }
        $guest->visit($this);
    }
}
