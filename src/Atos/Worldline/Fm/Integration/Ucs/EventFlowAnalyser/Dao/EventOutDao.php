<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class EventOutDao extends AbstractDao
{
    /**
     * Try to get eventOut from datasource
     * @param EventIn $eventIn
     * @param Event $event
     * @return EventOut
     */
    function get(EventIn $eventIn, Event $event) {
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('eventOut')
        ->from('UcsEventFlowAnalyser:EventOut', 'eventOut')
        ->where(
                $qb->expr()->andx(
                        $qb->expr()->eq('eventOut.event', ':event'),
                        $qb->expr()->eq('eventOut.eventIn', ':eventIn')
                )
        )
        ->setParameters(
                array (
                        'event'=> $event->getId(),
                        'eventIn' => $eventIn->getId()
                )
        )
        ->getQuery()
        ->getSingleResult();
    }
}
