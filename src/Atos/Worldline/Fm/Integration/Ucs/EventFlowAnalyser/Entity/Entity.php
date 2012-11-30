<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\IntegerType;

abstract class Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var IntegerType
     */
    protected $id;
    
    /**
     * @return IntegerType
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     *
     * @param IntegerType $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
}
