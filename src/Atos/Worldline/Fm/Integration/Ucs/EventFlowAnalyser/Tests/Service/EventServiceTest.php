<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Tests\Controller;

use Symfony\Component\Filesystem\Filesystem;

use FOS\UserBundle\Entity\UserManager;

use FOS\UserBundle\Security\UserProvider;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Tests\ContainerAwareUnit;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;

use Mylen\JQueryFileUploadBundle\Services\FileUploaderService;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ProjectService;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\UserBundle\Entity\User;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\EventService;

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