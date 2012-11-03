<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:04
 * EventFlow class represents an Event along with the parent events and its children events.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\Event;

class EventFlow
{

    /** @var $event Event */
    public $event;

    /** @var $parents [Event, mixed][] */
    public $parents;

    /** @var $children [Event, mixed][] */
    public $children;

    /**
     * @param $event Event
     * @param $parents Event[]
     * @param $children Event[]
     */
    public function __construct($event, $parents, $children)
    {
        $this->event = $event;
        $this->parents = $parents;
        $this->children = $children;
    }
}
