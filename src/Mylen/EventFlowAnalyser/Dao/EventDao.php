<?php
namespace Mylen\EventFlowAnalyser\Dao;
use Mylen\EventFlowAnalyser\Entity\Project;

use Doctrine\ORM\EntityManager;

use Mylen\EventFlowAnalyser\Entity\Event;

use Mylen\EventFlowAnalyser\Dao\AbstractDao;
use Monolog\Logger;

class EventDao extends AbstractDao
{
    /**
     * Try to get event from datasource
     * @param Project $project
     * @param string $type
     * @return Event
     */
    function getByType(Project $project, $type) {
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('event')
        ->from('EventFlowAnalyser:Event', 'event')
        ->where(
                $qb->expr()->andx(
                    $qb->expr()->eq('event.type', ':type'),
                    $qb->expr()->eq('event.project', ':project')
                    )
                )
        ->setParameters( 
                array (
                    'type'    => $type,
                    'project' => $project->getId(),
                    )
                )
        ->getQuery()
        ->getSingleResult();
    }
}
