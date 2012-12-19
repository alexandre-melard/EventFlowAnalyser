<?php
namespace Mylen\EventFlowAnalyser\Dao;

use Mylen\EventFlowAnalyser\Entity\Entity;
use Mylen\EventFlowAnalyser\Dao\Visitor\PersistVisitor;
use Mylen\EventFlowAnalyser\Dao\Visitor\RemoveVisitor;
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
     * @var RemoveVisitor
     */
    protected $rv;
    
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
     * @param Entity $entity
     */
    public function persist(Entity $entity)
    {
        $this->pv->persist($entity);
    }
    
    /**
     * @param Entity $entity
     */
    public function remove(Entity $entity)
    {
        $this->rv->remove($entity);
    }
    
    /**
     * 
     * @param PersistVisitor $pv
     */
    public function setPersistVisitor(PersistVisitor $pv)
    {
        $this->pv = $pv;
    }
    
    /**
     * 
     * @param RemoveVisitor $rv
     */
    public function setRemoveVisitor(RemoveVisitor $rv)
    {
        $this->rv = $rv;
    }
}
