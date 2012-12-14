<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Tests\Controller;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\ProjectDao;

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

class UserTest extends ContainerAwareUnit
{
    public function testInit() {
        /* @var $userManager UserManager */
        $userManager = $this->get('fos_user.user_manager');
        $this->assertNotNull($userManager);
        
        $user = $userManager->findUserByUsername('test');
        if (!$user) {
            $user = $userManager->createUser();
            $user->setUsername('test');
            $user->setPassword('test');
            $user->setEmail('test@test.com');
            $userManager->updateUser($user);
        }
        $this->assertNotNull($user);
        
        return $user;
    }
    
}