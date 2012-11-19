<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * Parser Type. A parser represent the parser xml output.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

class Parser
{
    public $file;
    public $xsd;

    /* @var $eventIns EventIn[] */
    public $eventIns;

    /**
     * @param $file xml parser result file path.
     */
    public function __construct($file, $xsd)
    {
        $this->file = $file;
        $this->xsd = $xsd;
        $this->eventIns = array();
    }

    /**
     * @param EventIn $event
     */
    public function addEventIn(EventIn $event)
    {
        if (!empty($event)) {
            array_push($this->eventIns, $event);
        }
    }

    /**
     * @param EventIn $event
     */
    public function removeEventIn(EventIn $event)
    {
        if (!empty($event)) {
            unset($this->eventIns[$event]);
        }
    }

}
