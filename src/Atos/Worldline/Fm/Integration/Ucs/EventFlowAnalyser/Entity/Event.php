<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:04
 * Ancestor class for all Events
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Event extends Entity implements VisitorHost
{
    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        $guest->visit($this);
    }
    
}
