<?php
namespace Mylen\EventFlowAnalyser\Entity;

use Doctrine\DBAL\Types\IntegerType;

interface Entity
{    
    /**
     * @return IntegerType
     */
    public function getId();

    /**
     *
     * @param IntegerType $id
     */
    public function setId($id);
    
}
