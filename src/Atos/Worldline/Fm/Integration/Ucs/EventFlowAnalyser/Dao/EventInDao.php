<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;

use Doctrine\ORM\NoResultException;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class EventInDao extends AbstractDao
{
    /**
     * Try to retrieve Event from datasource else instanciates one.
     * @param string $type
     */
    public function getEventIn($type)
    {
        try {
            $event = $this->em
            ->createQuery('
                    SELECT i FROM UcsEventFlowAnalyser:EventIn i
                    JOIN i.event e
                    WHERE e.type = :type'
                )
                ->setParameter('type', $type)
            ->getSingleResult();
        } catch ( NoResultException $e ) {
            $event = new EventIn();
        }    
    
        return $event;
    }
    
}
