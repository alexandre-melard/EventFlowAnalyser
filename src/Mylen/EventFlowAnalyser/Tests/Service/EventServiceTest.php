<?php

namespace Mylen\EventFlowAnalyser\Tests\Controller;

use Symfony\Component\Filesystem\Filesystem;

use FOS\UserBundle\Entity\UserManager;

use FOS\UserBundle\Security\UserProvider;

use Mylen\EventFlowAnalyser\Tests\ContainerAwareUnit;

use Mylen\EventFlowAnalyser\Service\ParserService;

use Mylen\JQueryFileUploadBundle\Services\FileUploaderService;

use Mylen\EventFlowAnalyser\Service\ProjectService;

use Mylen\EventFlowAnalyser\Entity\Document;
use Mylen\UserBundle\Entity\User;
use Mylen\EventFlowAnalyser\Entity\Project;
use Mylen\EventFlowAnalyser\Entity\Event;
use Mylen\EventFlowAnalyser\Service\EventService;

class EventServiceTest extends ContainerAwareUnit
{
    /**
     * @depends ProjectServiceTest::testPopulate
     * @param Project $project
     */
    public function testGetDocumentsByEvent(Project $project)
    {
        $event = $eventService->getEventByType($project, 'CORE_MSG_TYPE_RequestForTradeCreation');
        $documents = $eventService->getDocumentsByEvent($event);
        $this->assertEquals(2, count($documents));
    }    
    
}