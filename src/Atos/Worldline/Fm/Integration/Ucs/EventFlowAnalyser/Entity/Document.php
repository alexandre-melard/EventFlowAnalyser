<?php
/**
 * Created by JetBrains PhpStorm.
 * User: A140980
 * Date: 13/11/12
 * Time: 09:07
 * To change this template use File | Settings | File Templates.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;

use Symfony\Component\Filesystem\Filesystem;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Atos\Worldline\Fm\UserBundle\Entity\User;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Document extends Entity implements VisitorHost
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project")
     */
    protected $project;

    /**
     * @ORM\OneToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser", cascade={"all"})
     */
    protected $parser;

    protected $fs;
    protected $tmp;

    /**
     * 
     * @param $path path to the document
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->name = '';
        $this->fs = new Filesystem();
    }

    /**
     * Get document's name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set document's name
     * @param $name string
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the path to the document.
     * @return path to document
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path to the document.
     * @param path to document
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /** 
     * Get the tmp path to the document use while editing a project.
     * @return temporary path to document
     */
    public function getTmp()
    {
        return $this->tmp;
    }

    /** 
     * Set the tmp path to the document use while editing a project.
     * @param temporary path to document
     */
    public function setTmp($tmp)
    {
        $this->tmp = $tmp;
    }

    /**
     * Get document's associated project
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set document's associated project
     * @param Project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * Get associated Parser object
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * Set associated Parser object
     * @param Parser
     */
    public function setParser($parser)
    {
        $this->parser = $parser;
    }
    
    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        $this->parser->accept($guest);
        $guest->visit($this);
    }
    
}
