<?php
/**
 * Created by JetBrains PhpStorm.
 * User: A140980
 * Date: 13/11/12
 * Time: 09:07
 * To change this template use File | Settings | File Templates.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints as Assert;

use Atos\Worldline\Fm\UserBundle\Entity\User;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Document implements VisitorHost, Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var IntegerType
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $shaKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uri;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project", inversedBy="documents")
     */
    private $project;

    /**
     * @ORM\OneToOne(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser", inversedBy="document")
     */
    private $parser;

    private $tmp;

    /**
     * 
     * @param $path path to the document
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->name = '';
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

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // do whatever you want to generate a unique name
        $this->setKey(sha1(uniqid(mt_rand(), true)));
        $filename = $this->getKey() . '.' . pathinfo($this->path, PATHINFO_EXTENSION);
        
        // set the path right as the tmp folder will be remove after persist.
        $tmp = $this->path;
        $this->setPath(dirname($this->tmp) . '/' . $filename);
        $this->setUri(dirname($this->uri) . '/' . $filename);
        $this->setTmp($tmp);
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $fs = new Filesystem();
        $fs->rename($this->getTmp(), $this->getPath());
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $fs = new Filesystem();
        $fs->remove($this->getPath());
    }
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

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getKey()
    {
        return $this->shaKey;
    }

    public function setKey($key)
    {
        $this->shaKey = $key;
    }

}
