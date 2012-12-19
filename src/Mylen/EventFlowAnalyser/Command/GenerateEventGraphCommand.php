<?php
namespace Mylen\EventFlowAnalyser\Command;

use Mylen\EventFlowAnalyser\Service\ProjectService;
use Mylen\EventFlowAnalyser\Service\GraphVizService;
use Mylen\EventFlowAnalyser\Service\EventService;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class GenerateEventGraphCommand extends ContainerAwareCommand    
{
    protected function configure()
    {
        $this
        ->setName('analyser:graph:event')
        ->setDescription('Generate graph for an event')
        ->addArgument('user', InputArgument::REQUIRED, 'User')
        ->addArgument('project', InputArgument::REQUIRED, 'Project')
        ->addArgument('event', InputArgument::REQUIRED, 'Event')
        ->addArgument('file', InputArgument::OPTIONAL, 'Output File')
        ;        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $eventName = $input->getArgument('event');
        $projectName = $input->getArgument('project');
        $userName = $input->getArgument('user');
        
        /* @var $projectService ProjectService */
        $projectService = $this->getContainer()->get('app.project');
        
        /* @var $eventService EventService */
        $eventService = $this->getContainer()->get('app.event');

        /* @var $graphService GraphVizService */
        $graphService = $this->getContainer()->get('app.graph');
        
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($userName);
        
        
        $project = $projectService->getProject($user, $projectName);
        $event = $eventService->getEventByType($project, $eventName);
        $out = $graphService->generateEventGraph($event);
        
        $file = $input->getArgument('file');
        if (null !== $file) {
            $handle = fopen($file, 'w');
            fwrite($handle, $out);
            fclose($handle);
        } else {
            $output->writeln($out);
        }
    }
}
