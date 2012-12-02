<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class ParserDao extends AbstractDao
{
    /**
     * Try to get parser from datasource
     * @param Document $document
     * @return Parser
     */
    function get(Document $document) {
        $qb = $this->em->createQueryBuilder();
        return $qb
        ->select('parser', 'eventIns')
        ->from('UcsEventFlowAnalyser:Parser', 'parser')
        ->leftJoin('parser.eventIns', 'eventIns')
        ->where($qb->expr()->eq('parser.document', ':document'))
        ->setParameter('document', $document->getId())
        ->getQuery()
        ->getSingleResult();
    }
}
