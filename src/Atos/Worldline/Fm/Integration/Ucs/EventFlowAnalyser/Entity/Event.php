<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:04
 * Ancestor class for all Events
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Event  implements VisitorHost, Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var IntegerType
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project", inversedBy="events")
     */
    private $project;
    
    /**
     * @ORM\ManyToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn")
     */
    private $parents;
    
    /**
     * @ORM\ManyToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut")
     */
    private $children;
    
    public function __construct($type)
    {
        $this->type = $type;
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        if (isset($this->eventFlow)) {
            $this->eventFlow->accept($guest);
        }
        $guest->visit($this);
    }
    
    public function getShortEvent()
    {
        return str_replace("CORE_MSG_TYPE_", "", $this->getType());
    }
    
    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public function setProject($project)
    {
        $this->project = $project;
    }
    
    /**
     *
     * @return EventIn
     */
    public function getParents()
    {
        return $this->parents;
    }
    
    public function setParents($parents)
    {
        $this->parents = $parents;
    }
    
    public function addParent(EventIn $parent) {
        $this->parents[$parent->getType()] = $parent;
    }
    
    public function removeParent(EventIn $parent) {
        unset($this->parents[$parent->getType()]);
    }
    
    public function getParent(EventIn $parent) {
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
    
    public function addChild(EventOut $child) {
        $this->children[$child->getType()] = $child;
    }
    
    public function removeChild(EventOut $child) {
        unset($this->children[$child->getType()]);
    }
    
    public function getChild(EventOut $child) {
        return $this->children[$child->getType()];
    }
    
}
