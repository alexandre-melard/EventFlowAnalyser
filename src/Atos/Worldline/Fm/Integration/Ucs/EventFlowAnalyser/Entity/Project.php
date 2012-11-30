<?php
/**
 * User: A140980
 * Date: 29/11/12
 * Time: 10:07
 * Project entity
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Symfony\Component\Finder\Finder;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;

use Symfony\Component\Filesystem\Filesystem;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Project extends Entity implements VisitorHost
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=8)
     * @Assert\NotBlank
     */
    protected $visibility;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * One to Many type 
     * @ORM\ManyToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document")
     */
    protected $documents;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    protected $path;

    protected $tmp;

    /* @var $parserService ParserService */
    protected $parserService;

    /**
     * 
     * @param User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->visibility = 'public';
        $this->name = '';
        $this->fs = new Filesystem();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // Create data directory if soft is new, clear it if not
        if ($this->fs->exists($this->path)) {
            $this->fs->remove($this->path);
        }
        $this->fs->mkdir($this->path);
    }

    public function populate()
    {
        if ($this->parserService === null) {
            throw new Exception("parserService must be set");
        }
        $finder = new Finder();
        $finder->in($this->path);
        foreach ($finder as $file) {
            /* @var $file SplFileInfo */
            $document = new Document($file->getPathname());
            $document->setName($file->getBasename('.xml'));
            $document->setProject($this);
            $document->setTmp($this->tmp);
            $this->addDocument($document);
        }
        $this->documents = $this->parserService->parseDocuments($this->documents);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $this->fs->remove($this->path);
    }

    /**
     * @return Name of the project
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the project
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the visibility for a project (public or private)
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the visibility for a project (public or private)
     * @param string
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * return project's owner
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set project's owner
     * @param User $user 
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get documents associated with the project
     * @return Document[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set documents associated with the project
     * @param Document[] $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * Add document to the project
     * @param Document
     */
    public function addDocument(Document $document)
    {
        $this->documents[$document->getName()] = $document;
    }

    /**
     * Remove document associated with the project
     * @param Document $document
     * @return Document the removed document
     */
    public function removeDocuments($document)
    {
        unset($this->documents[$document->getName()]);
        return $document;
    }

    /**
     * @return path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getTmp()
    {
        return $this->tmp;
    }

    public function setTmp($tmp)
    {
        $this->tmp = $tmp;
    }

    public function setParserService(ParserService $parserService)
    {
        $this->parserService = $parserService;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        foreach ($this->documents as $document) {
            /* @var $document Document */
            $document->accept($guest);
        }
        $guest->visit($this);
    }

}
