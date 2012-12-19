<?php
namespace Mylen\EventFlowAnalyser\Dao\Visitor;

use Mylen\EventFlowAnalyser\Entity\Entity;
use Mylen\EventFlowAnalyser\Patterns\VisitorHost;

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
