<?php
namespace Mylen\EventFlowAnalyser\Dao\Visitor;

use Mylen\EventFlowAnalyser\Patterns\VisitorHost;
use Mylen\EventFlowAnalyser\Patterns\VisitorGuest;
use Doctrine\ORM\EntityManager;

abstract class AbstractEntityVisitor implements VisitorGuest {
    
    /* @var $em EntityManager*/
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public abstract function visit(VisitorHost $host);
}
