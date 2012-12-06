<?php
/**
 * User: A140980
 * Date: 29/11/12
 * Time: 10:07
 * Project entity
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\NoResultException;

use Symfony\Component\Validator\Constraints as Assert;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ProjectService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorGuest;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns\VisitorHost;

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
     * @ORM\Column(type="string", length=255)
     */
    private $shaKey;

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

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $webPath;

    /**
     * @var ProjectService
     */
    protected $projectService;

    private $tmp;

    /**
     * 
     * @param User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->visibility = 'public';
        $this->name = '';
    }

    /**
     * (non-PHPdoc)
     * @see Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Patterns.VisitorHost::accept()
     */
    public function accept(VisitorGuest $guest)
    {
        foreach ($this->getEvents() as $event) {
            /* @var $event Event */
            $event->accept($guest);
        }
        foreach ($this->documents as $document) {
            /* @var $document Document */
            $document->accept($guest);
        }
        $guest->visit($this);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->projectService->createDir($this->getPath(), true);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $this->projectService->removeDir($this->getPath());
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

    /**
     * @return array Event
     */
    public function getEvents()
    {
        if (!isset($this->events)) {
            $this->events = array();
        }

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
     * add event to associated array event
     * @param Event $event
     * @return Event
     */
    public function addEvent(Event $event)
    {
        if (!isset($this->events)) {
            $this->events = array();
        }
        $this->events[$event->getType()] = $event;
        return $event;
    }

    /**
     * Set the project services container
     * @param ProjectService $projectService
     */
    public function setProjectService(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function getWebPath()
    {
        return $this->webPath;
    }

    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;
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
