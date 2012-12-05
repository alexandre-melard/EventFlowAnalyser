<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;

use Atos\Worldline\Fm\UserBundle\Entity\User;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class DocumentDao extends AbstractDao
{
    /**
     * Try to get event from datasource
     * @param User $user
     * @param Project $project
     * @param string $name
     * @return Document
     */
    function get(User $user, Project $project, string $name) {
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('document')
        ->from('UcsEventFlowAnalyser:Document', 'document')
        ->leftJoin('UcsEventFlowAnalyser:Project', 'project')
        ->where(
                $qb->expr()->andx(
                    $qb->expr()->eq('document.name', ':name'), 
                    $qb->expr()->eq('document.project', ':project'),
                    $qb->expr()->eq('project.user', ':user')
                    )
                )
        ->setParameters( 
                array (
                    'name'    => $name,
                    'project' => $project->getId(),
                    'user'    => $user->getId()
                    )
                )
        ->getQuery()
        ->getSingleResult();
    }
    
    /**
     * Try to get event from datasource
     * @param User $user
     * @param string $key
     * @return Document
     */
    function getByKey(User $user, $key) {
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('document')
        ->from('UcsEventFlowAnalyser:Document', 'document')
        ->leftJoin('document.project', 'project')
        ->where(
                $qb->expr()->andx(
                    $qb->expr()->eq('document.shaKey', ':shaKey'), 
                    $qb->expr()->eq('project.user', ':user')
                    )
                )
        ->setParameters( 
                array (
                    'shaKey'    => $key,
                    'user'    => $user->getId()
                    )
                )
        ->getQuery()
        ->getSingleResult();
    }
    
    /**
     * Try to get all events for one project from datasource
     * @param User $user
     * @param Project $project
     * @return array Document
     */
    function getAll(User $user, Project $project) {
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('document')
        ->from('UcsEventFlowAnalyser:Document', 'document')
        ->where(
                $qb->expr()->andx(
                        $qb->expr()->eq('document.project', ':project'),
                        $qb->expr()->eq('document.project.user', ':user')
                )
        )
        ->setParameters(
                array (
                        'project' => $project->getId(),
                        'user'    => $user->getId()
                )
        )
        ->getQuery()
        ->getResult();
    }    
}
