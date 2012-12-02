<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * Parser Type. A parser represent the parser xml output.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Entity;
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
     * @ORM\OneToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document")
     */
    private $document;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $xsd;

    /**
     * One to Many 
     * @ORM\OneToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn", mappedBy="parser")
     * @var array
     */
    private $eventIns;

    /**
     * @param $document xml parser result document path.
     */
    public function __construct($d)
    {
        $this->document = $d;
        $this->eventIns = array();
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

    public function getXsd()
    {
        return $this->xsd;
    }

    public function setXsd($xsd)
    {
        $this->xsd = $xsd;
    }

    /**
     * return array Events in
     */
    public function getEventIns()
    {
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
    
    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        foreach ($this->getEventIns() as $eventIn) {
            /* @var $eventIn EventIn */
            $eventIn->accept($guest);
        }
        $guest->visit($this);
    }
    
}
