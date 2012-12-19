<?php

namespace Mylen\UserBundle\Tests\Controller;

use Mylen\UserBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        $user = new User();
        $this->assertNotNull($user);
    }
}
