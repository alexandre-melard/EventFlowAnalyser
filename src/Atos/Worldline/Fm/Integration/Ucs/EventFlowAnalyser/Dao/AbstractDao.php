<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Entity;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\Visitor\PersistVisitor;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

abstract class AbstractDao
{
    /**
     *  @var Logger 
     */
    protected $logger;
    
    /**
     *  @var EntityManager 
     */
    protected $em;
    
    /**
     * @var PersistVisitor
     */
    protected $pv;

    /**
     * Return new Dao with Entity Manager and Logger
     * @param EntityManager $em
     * @param Logger $l
     */
    public function __construct(EntityManager $em, Logger $l) 
    {
        $this->logger = $l;
        $this->em = $em;
    }
    
    /**
     * Commit to database
     */
    public function flush() 
    {
        $this->em->flush();
    }
    
    /**
     * @param Project $project
     */
    public function persist(Entity $entity)
    {
        $this->pv->persist($entity);
    }
    
    /**
     * 
     * @param PersistVisitor $pv
     */
    public function setPersistVisitor(PersistVisitor $pv)
    {
        $this->pv = $pv;
    }
}
