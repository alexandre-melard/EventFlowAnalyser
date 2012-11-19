<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:07
 * EventOut class type. Barely an Event... For now.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

class EventOut extends Event
{
    public function __construct($type)
    {
        parent::__construct($type);
    }
}
