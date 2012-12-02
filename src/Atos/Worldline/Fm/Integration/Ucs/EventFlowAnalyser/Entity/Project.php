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
class Project implements Entity, VisitorHost
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
     * @ORM\Column(type="string", length=8)
     * @Assert\NotBlank
     */
    private $visibility;

    /**
     * @ORM\ManyToOne(targetEntity="Atos\Worldline\Fm\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document", mappedBy="project")
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity="Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event", mappedBy="project")
     */
    private $events;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $path;

    private $tmp;

    /* @var $parserService ParserService */
    private $parserService;

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
        $this->events = array();
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

    /**
     * @return array Event
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * 
     * @param array Event $events
     */
    public function setEvents(array $events)
    {
        $this->events = $events;
    }
    
    /**
     * return associated event
     * @param string $type
     */
    public function getEvent($type) 
    {
        return $this->events[$type];
    }

    /**
     * add event to associated array event
     * @param Event $event
     * @return Event
     */
    public function addEvent(Event $event)
    {
        $this->events[$event->getType()] = $event;
        return $event; 
    }
}
