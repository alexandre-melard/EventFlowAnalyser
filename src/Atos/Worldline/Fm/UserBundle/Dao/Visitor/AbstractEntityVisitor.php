<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\Visitor;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;
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
