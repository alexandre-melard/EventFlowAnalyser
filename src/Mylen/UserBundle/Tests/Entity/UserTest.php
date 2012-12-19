<?php

namespace Atos\Worldline\Fm\UserBundle\Tests\Controller;

use Atos\Worldline\Fm\UserBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        $user = new User();
        $this->assertNotNull($user);
    }
}
