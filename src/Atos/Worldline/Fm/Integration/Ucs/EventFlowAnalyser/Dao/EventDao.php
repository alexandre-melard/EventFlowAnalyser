<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;
use Doctrine\ORM\EntityManager;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;
use Monolog\Logger;

class EventDao extends AbstractDao
{
    protected $events;

     /**
      * @param EntityManager $em
      * @param Logger $l
      */
     public function __construct(EntityManager $em, Logger $l) {
         parent::__construct($em, $l);
         $this->events = array();
     }

    /**
     * Try to retrieve Event from datasource else instanciates one. 
     * @param string $type
     */
    public function getEvent($type) 
    {
        $event = $this->em
                    ->getRepository('UcsEventFlowAnalyser:Event')
                    ->findOneBy(
                            array(
                                    'type' => $type
                            )
                    );
        if (!isset($event)) {
            if (!isset($this->events[$type])) {
                $event = new Event($type);
                $this->events[$type] = $event;
            } else {
                $event = $this->events[$type];
            }
        }
        
        return $event;
    }
}
