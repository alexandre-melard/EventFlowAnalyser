<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * Parser Type. A parser represent the parser xml output.
 */
namespace Mylen\EventFlowAnalyser\Entity;

use Mylen\EventFlowAnalyser\Patterns\VisitorGuest;

use Mylen\EventFlowAnalyser\Patterns\VisitorHost;
use Mylen\EventFlowAnalyser\Entity\Document;
use Mylen\EventFlowAnalyser\Entity\EventIn;
use Mylen\EventFlowAnalyser\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Parser implements Entity, VisitorHost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var IntegerType
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Mylen\EventFlowAnalyser\Entity\Document", mappedBy="parser")
     */
    private $document;

    /**
     * One to Many 
     * @ORM\OneToMany(targetEntity="Mylen\EventFlowAnalyser\Entity\EventIn", mappedBy="parser")
     * @var array
     */
    private $eventIns;

    /**
     * @param $document xml parser result document path.
     */
    public function __construct($d)
    {
        $this->document = $d;
    }
    
    /**
     * (non-PHPdoc)
     * @see Mylen\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        foreach ($this->getEventIns() as $eventIn) {
            /* @var $eventIn EventIn */
            $eventIn->accept($guest);
        }
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
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * return array Events in
     */
    public function getEventIns()
    {
        if (!isset($this->eventIns)) {
            $this->eventIns = array();
        }
        return $this->eventIns;
    }

    /**
     * Set input events
     * @param array $eventIns
     */
    public function setEventIns(array $eventIns)
    {
        $this->eventIns = $eventIns;
    }

    /**
     * Add en event in to the input events
     * @param EventIn $event
     */
    public function addEventIn(EventIn $event)
    {
        $this->eventIns[$event->getType()] = $event;
    }

    /**
     * remove an element from the input events
     * @param EventIn $event
     */
    public function removeEventIn(EventIn $event)
    {
        unset($this->eventIns[$event->getType()]);
        return $event;
    }
    
}
