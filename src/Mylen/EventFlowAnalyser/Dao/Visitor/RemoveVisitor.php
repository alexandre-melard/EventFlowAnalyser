<?php
namespace Mylen\EventFlowAnalyser\Dao\Visitor;

use Mylen\EventFlowAnalyser\Entity\Entity;
use Mylen\EventFlowAnalyser\Patterns\VisitorHost;

class RemoveVisitor extends AbstractEntityVisitor 
{
    public function remove(VisitorHost $host) {
        $host->accept($this);
    }
    
    public function visit(VisitorHost $host)
    {
        if ( $host InstanceOf Entity ) {
            $this->em->remove($host);
        }
    }
}
