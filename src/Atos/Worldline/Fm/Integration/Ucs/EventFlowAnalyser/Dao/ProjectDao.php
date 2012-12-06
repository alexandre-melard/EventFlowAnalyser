<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;

use Doctrine\ORM\QueryBuilder;

use Atos\Worldline\Fm\UserBundle\Entity\User;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class ProjectDao extends AbstractDao
{
    /**
     * 
     * @param User $user
     * @param string $visibility
     * @param string $name
     * @return Project
     */
    function get(User $user, $name) {

        $qb = $this->em->createQueryBuilder();
        return $qb
            ->select('Project', 'documents', 'events')
            ->from('UcsEventFlowAnalyser:Project', 'Project')
            ->leftJoin('Project.documents', 'documents')
            ->leftJoin('Project.events', 'events')
            ->where($qb->expr()->andx(
                    $qb->expr()->eq('Project.name', ':name'),
                    $qb->expr()->eq('Project.user', ':user')
                    )
            )
            ->setParameters( array (
                                    'name' => $name,
                                    'user' => $user->getId()
                                    )
                            )
            ->getQuery()
            ->getSingleResult();
    }    

    /**
     *
     * @param User $user
     * @return object
     */
    function getAllByUser(User $user) {
    
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('Project', 'documents')
        ->from('UcsEventFlowAnalyser:Project', 'Project')
        ->leftJoin('Project.documents', 'documents')
        ->where($qb->expr()->orx(
                    $qb->expr()->eq('Project.visibility', ':public'),
                    $qb->expr()->andx(
                        $qb->expr()->eq('Project.visibility', ':private'),
                        $qb->expr()->eq('Project.user', ':user')
                        )
                    )
                )
        ->setParameters(
                array (
                    'public' => 'public',
                    'private' => 'private',
                    'user' => $user->getId()
                    )
                )
        ->getQuery()
        ->getResult();
    }
    
    /**
     *
     * @param User $user
     * @return object
     */
    function getAllByVisibility(User $user, $visibility) {
    
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('Project', 'documents')
        ->from('UcsEventFlowAnalyser:Project', 'Project')
        ->leftJoin('Project.documents', 'documents')
        ->where($qb->expr()->andx(
                    $qb->expr()->eq('Project.visibility', ':visibility'),
                    $qb->expr()->eq('Project.user', ':user')
                    )
                )
        ->setParameters(
                array (
                        'visibility' => $visibility,
                        'user' => $user->getId()
                )
        )
        ->getQuery()
        ->getResult();
    }
    
}
