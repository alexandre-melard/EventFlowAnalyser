<?php

namespace Mylen\EventFlowAnalyser\Tests\Controller;

use Mylen\EventFlowAnalyser\Dao\ProjectDao;

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