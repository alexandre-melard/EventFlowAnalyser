<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;

use Doctrine\ORM\NoResultException;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class EventInDao extends AbstractDao
{
    /**
     * Try to get eventOut from datasource
     * @param Parser $parser
     * @param Event $event
     * @return EventOut
     */
    function get(Parser $parser, Event $event) {
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('eventIn', 'eventOuts')
        ->from('UcsEventFlowAnalyser:EventIn', 'eventIn')
        ->leftJoin('eventIn.eventOuts', 'eventOuts')
        ->where(
                $qb->expr()->andx(
                        $qb->expr()->eq('eventIn.event', ':event'),
                        $qb->expr()->eq('eventIn.parser', ':parser')
                        )
                )
        ->setParameters(
                array (
                        'event'=> $event->getId(),
                        'parser' => $parser->getId()
                        )
                )
        ->getQuery()
        ->getSingleResult();
    }
}
