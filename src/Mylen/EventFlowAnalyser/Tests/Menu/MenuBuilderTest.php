<?php

namespace Mylen\EventFlowAnalyser\Tests\Menu;



use Mylen\EventFlowAnalyser\Tests\ContainerAwareUnit;
use Mylen\EventFlowAnalyser\Menu\MenuBuilder;
use Atos\Worldline\Fm\UserBundle\Entity\User;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\ParameterBag;

use FOS\UserBundle\Security\UserProvider;
use Knp\Menu\ItemInterface;
use Mockery as m;

class MenuBuilderTest extends ContainerAwareUnit
{

    public function testSetSecurityContext()
    {
        $menuBuilder = $this->get('event_flow_analyser.menu_builder');;
        
        $securityContext = m::mock('Symfony\Component\Security\Core\SecurityContextInterface');

        $securityContext->shouldReceive('isGranted')
        ->with('IS_AUTHENTICATED_FULLY')
        ->once()
        ->andReturn(true);

        
        $user = m::mock('Atos\Worldline\Fm\UserBundle\Entity\User');
        
        $securityContext->shouldReceive('getToken->getUser')
        ->withNoArgs()
        ->once()
        ->andReturn($user);
        
        $menuBuilder->setSecurityContext($securityContext);
        
        return $menuBuilder;
    }
    
    /**
     * @depends testSetSecurityContext
     */
    public function testSetLogger(MenuBuilder $menu)
    {
        $logger = m::mock('Monolog\Logger');
        $logger->shouldReceive('debug')
        ->with(anything())
        ->andReturn();
        
        $menu->setLogger($logger);
        
        return $menu;
    }
    
    /**
     * @depends testSetLogger
     */
    public function testSetProjectDao(MenuBuilder $menu)
    {
        $document = m::mock('Mylen\EventFlowAnalyser\Entity\Document');
        $document->shouldReceive('getName')
        ->andReturn('doc');
        
        $event = m::mock('Mylen\EventFlowAnalyser\Entity\Event');
        $event->shouldReceive('getShortEvent')->andReturn('event');
        $event->shouldReceive('getType')->andReturn('TYPE');
        
        $project = m::mock('Mylen\EventFlowAnalyser\Entity\Project');
        $project->shouldReceive(array('getDocuments' => array($document), 'getEvents' => array($event), 'getName' => 'project'));
        
        $projectDao = m::mock('Mylen\EventFlowAnalyser\Dao\ProjectDao');
        $projectDao->shouldReceive('get')->with(anything(), anything())->andReturn($project);

        $menu->setProjectDao($projectDao);
        
        return $menu;
    }
    
    /**
     * @depends testSetProjectDao
     */
    public function testCreateMainMenu(MenuBuilder $menu)
    {
        $request = m::mock('Symfony\Component\HttpFoundation\Request');
        $request->attributes = new ParameterBag(array('projectName' => 'project'));
        
        $nav = $menu->createMainMenu($request);
        $this->assertNotNull($nav);
        
        $this->assertNotNull($nav->getChild('Home'));
        $this->assertNotNull($nav->getChild('Profile'));
        $this->assertNotNull($nav->getChild('Projects'));
    }

    /**
     * @depends testSetProjectDao
     */
    public function testCreateMainMenuNoAuth(MenuBuilder $menu)
    {
        $securityContext = m::mock('Symfony\Component\Security\Core\SecurityContextInterface');

        $securityContext->shouldReceive('isGranted')
        ->with('IS_AUTHENTICATED_FULLY')
        ->once()
        ->andThrow(new \Exception(), 'no user');
        $menu->setSecurityContext($securityContext);
        
        $request = m::mock('Symfony\Component\HttpFoundation\Request');
        $request->attributes = new ParameterBag(array('projectName' => 'project'));
    
        $nav = $menu->createMainMenu($request);
        $this->assertNotNull($nav);
    
        $this->assertNotNull($nav->getChild('Home'));
        $this->assertNotNull($nav->getChild('Profile'));
        $this->assertEquals(null, $nav->getChild('Projects'));
    }
    
}