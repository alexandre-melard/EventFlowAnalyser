<?php
namespace Mylen\EventFlowAnalyser\Service;

use Mylen\UserBundle\Entity\User;

use Mylen\EventFlowAnalyser\Dao\EventDao;
use Mylen\EventFlowAnalyser\Entity\Event;
use Mylen\EventFlowAnalyser\Entity\Project;
use Mylen\EventFlowAnalyser\Service\ProjectService;

class EventService
{
    /**
     * @var EventDao
     */
    private $eventDao;
    
    /**
     * @var ProjectService
     */
    private $projectService;
    
    /**
     * Get project from project service
     * @param User $user
     * @param string $visibility
     * @param string $name
     */
    public function getProject(User $user, $name)
    {
        return $this->projectService->getProject($user, $name);
    }
    
    /**
     * Get an Event providing it's current project and type.
     * @param Project $project
     * @param string $type
     */
    public function getEventByType(Project $project, $type)
    {
        return $this->eventDao->getByType($project, $type);
    }

    /**
     * Return list($in, $out) of documents where Event is respectly an Input or an Output.
     * @param Event $event
     * @return array(array Document, array Document)
     */
    public function getDocumentsByEvent(Event $event)
    {
        /* @var $project Project */
        $project = $event->getProject();
        
        $in = array();
        $out = array();
        foreach ($project->getDocuments() as $document) {
            /* @var $document Document */
            foreach ($document->getParser()->getEventIns() as $eventIn) {
                /* @var $eventIn EventIn */
                if($eventIn->getEvent() == $event) {
                    $in[] = $document;
                }
                foreach ($eventIn->getEventOuts() as $eventOut) {
                    /* @var $eventOut EventOut */
                    if($eventOut->getEvent() == $event) {
                        $out[] = $document;
                    }
                }
            }
        }
        return array($in, $out);
    }
    
    /**
     * @param EventDao $eventDao
     */
    public function setEventDao(EventDao $eventDao)
    {
        $this->eventDao = $eventDao;
    }
    
    /**
     * @param ProjectDao $projectService
     */
    public function setProjectService(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
}
