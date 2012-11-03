<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:07
 * EventIn class type. An event aggregates 0..* EventOut.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity;

class EventIn extends Event
{
    /* @var $eventOuts EventOut[] */
    public $eventOuts;

    public function __construct($type)
    {
        parent::__construct($type);
        $this->eventOuts = array();
    }

    public function addEventOut(EventOut $event)
    {
        if (!empty($event)) {
            array_push($this->eventOuts,$event);
        }
    }

    public function removeEventOut(EventOut $event)
    {
        if (!empty($event)) {
            unset($this->eventOuts[$event]);
        }
    }
}
