<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/events');

        $this->assertTrue($crawler->filter('html:contains("Welcome")')->count() > 0);
    }
}
