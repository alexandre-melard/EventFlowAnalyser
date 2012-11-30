<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;

use Doctrine\ORM\QueryBuilder;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Atos\Worldline\Fm\UserBundle\Entity\User;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class ProjectDao extends AbstractDao
{
    /**
     * Try to retrieve Event from datasource else instanciates one.
     * @param string $type
     */
    /**
     * 
     * @param User $user
     * @param unknown_type $visibility
     * @param unknown_type $name
     * @return object
     */
    function get(User $user, $visibility, $name) {
        /* @var $qb QueryBuilder */
        $qb = $this->em->createQueryBuilder();
        $qb = $qb
                ->select('Project', 'documents')
                ->from('UcsEventFlowAnalyser:Project', 'Project')
                ->leftJoin('Project.documents', 'documents')
                ->where($qb->expr()->andx(
                        $qb->expr()->eq('Project.name', ':name'),
                        $qb->expr()->eq('Project.visibility', ':visibility'),
                        $qb->expr()->eq('Project.user', ':user')
                        )
                );
        $dql = $qb->getDql();
        $qb = $qb->setParameters( array (
                                            'name' => $name,
                                            'visibility' => $visibility,
                                            'user' => $user->getId()
                                            )
                                );
        $query = $qb->getQuery();
        $project = $query->getSingleResult();
        return $project;
    }
    
}
