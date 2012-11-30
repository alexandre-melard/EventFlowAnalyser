<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\Visitor;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Entity;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;

class PersistVisitor extends AbstractEntityVisitor 
{
    public function persist(VisitorHost $host) {
        $host->accept($this);
    }
    
    public function visit(VisitorHost $host)
    {
        if ( $host InstanceOf Entity ) {
            $this->em->persist($host);
        }
    }
}
