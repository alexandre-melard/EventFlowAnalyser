<?php
namespace Mylen\EventFlowAnalyser\Command;

use Mylen\EventFlowAnalyser\Entity\Project;

use Mylen\EventFlowAnalyser\Service\ProjectService;
use Mylen\EventFlowAnalyser\Service\GraphVizService;
use Mylen\EventFlowAnalyser\Service\EventService;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ProjectListCommand extends ContainerAwareCommand    
{
    protected function configure()
    {
        $this
        ->setName('analyser:project:list:user')
        ->setDescription('Output all projects')
        ->addArgument('user', InputArgument::REQUIRED, 'User')
        ;        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userName = $input->getArgument('user');
        
        /* @var $projectService ProjectService */
        $projectService = $this->getContainer()->get('app.project');
        
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($userName);
        
        $projects = $projectService->getAllProject($user);
        foreach ($projects as $project) {
            /* @var $project Project */
            $output->write('name:' . $project->getName());
            $output->writeln("\tvisibility:" . $project->getVisibility());
        }
    }
}
