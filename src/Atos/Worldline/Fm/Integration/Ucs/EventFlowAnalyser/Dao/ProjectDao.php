<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;

use Doctrine\ORM\QueryBuilder;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Atos\Worldline\Fm\UserBundle\Entity\User;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class ProjectDao extends AbstractDao
{
    /**
     * 
     * @param User $user
     * @param string $visibility
     * @param string $name
     * @return object
     */
    function get(User $user, $visibility, $name) {

        $qb = $this->em->createQueryBuilder();
        return $qb
            ->select('Project', 'documents')
            ->from('UcsEventFlowAnalyser:Project', 'Project')
            ->leftJoin('Project.documents', 'documents')
            ->where($qb->expr()->andx(
                    $qb->expr()->eq('Project.name', ':name'),
                    $qb->expr()->eq('Project.visibility', ':visibility'),
                    $qb->expr()->eq('Project.user', ':user')
                    )
            )
            ->setParameters( array (
                                        'name' => $name,
                                        'visibility' => $visibility,
                                        'user' => $user->getId()
                                        )
                            )
            ->getQuery()
            ->getSingleResult();
    }    
}
