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

use Mockery as m;

class ProjectServiceTest extends ContainerAwareUnit
{
    /**
     * @return ProjectService
     */
    public function testInit() 
    {
        /* @var $projectService ProjectService */
        $projectService = $this->get('app.project');
        $this->assertNotNull($projectService);
        return $projectService;
    }

    /**
     * @depends testInit
     * @param ProjectService $projectService
     * @return Project
     */
    public function testProjectInit(ProjectService $projectService) 
    {
        $user = m::mock('Mylen\UserBundle\Entity\User');
        $user->shouldReceive('getSalt')->andReturn('1234EZA');
        $project = new Project($user);
        $projectService->init($project);
        return $project;
    }
    
    /**
     * @depends testProjectInit
     * @param Project $project
     * @return Project 
     */
    public function testGetProject(Project $project) 
    {
        $projectDao = m::mock('Mylen\EventFlowAnalyser\Dao\ProjectDao');
        $projectDao->shouldReceive('get')->with(anything(), anything())->andReturn($project);
        
        $projectService = $this->get('app.project');
        
        $projectService->setProjectDao($projectDao);
        $projectRes = $projectService->getProject(new User(), null);

        $this->assertEquals($projectRes, $project);
                
        return $project;
    }

    /**
     * @depends testInit
     * @param ProjectService $projectService
     * @return ProjectService 
     */
    public function testCreateTmp(ProjectService $projectService)
    {
        $project = m::mock('Mylen\EventFlowAnalyser\Entity\Project');
        $project->shouldReceive('setKey')->once()->with(anything());
        $project->shouldReceive('setTmp')->atMost()->twice()->with(anything());
        $project->shouldReceive('getTmp')->andReturn($this->getParameter('file_uploader.file_base_path') . DIRECTORY_SEPARATOR . 'tmp');
        $value = sha1(uniqid(mt_rand(), true));
        $project->shouldReceive('getKey')->atLeast()->twice()->andReturn(null, $value);
        $projectService->createTmp($project);
        $this->assertEquals($value, $project->getKey());
    
        return $projectService;
    }
        
}