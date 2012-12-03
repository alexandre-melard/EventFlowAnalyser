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
class EventFlow implements VisitorHost, Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var IntegerType
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event")
     */
    private $event;

    /**
     * One to Many type TODO : check if join tables are necessary
     * @ORM\OneToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut", mappedBy="eventFlow")
     */
    private $parents;

    /**
     * One to Many type TODO : check if join tables are necessary
     * @ORM\OneToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn", mappedBy="eventFlow")
     */
    private $children;

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
    
    public function addparent(EventOut $parent) {
        $this->parents[$parent->getType()] = $parent;
    }
    
    public function removeparent(EventOut $parent) {
        unset($this->parents[$parent->getType()]);
    }
    
    public function getparent(EventOut $parent) {
        return $this->parents[$parent->getType()];
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
    
    public function addChild(EventIn $child) {
        $this->children[$child->getType()] = $child;
    }
    
    public function removeChild(EventIn $child) {
        unset($this->children[$child->getType()]);
    }
    
    public function getchild(EventIn $child) {
        return $this->children[$child->getType()];
    }
    
    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        $guest->visit($this);
    }
}
