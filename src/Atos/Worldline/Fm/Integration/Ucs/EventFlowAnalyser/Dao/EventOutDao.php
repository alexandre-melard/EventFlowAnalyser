<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;

use Doctrine\ORM\NoResultException;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class EventOutDao extends AbstractDao
{
    /**
     * Try to retrieve Event from datasource else instanciates one.
     * @param string $type
     */
    public function getEventOut($type)
    {

        try {
            $event = $this->em
            ->createQuery('
                    SELECT i FROM UcsEventFlowAnalyser:EventOut i
                    JOIN i.event e
                    WHERE e.type = :type'
            )
            ->setParameter('type', $type)
            ->getSingleResult();
        } catch ( NoResultException $e ) {
            $event = new EventOut();
            $this->em->persist($event);
        }
        if (!isset($event)) {
            $event = new EventOut();
        }
    
        return $event;
    }
}
