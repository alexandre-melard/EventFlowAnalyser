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

class ProjectListPrivateCommand extends ContainerAwareCommand    
{
    protected function configure()
    {
        $this
        ->setName('analyser:project:list:private')
        ->setDescription('Output all private projects')
        ;        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $projectService ProjectService */
        $projectService = $this->getContainer()->get('app.project');
        
        $projects = $projectService->getAllPrivate();
        foreach ($projects as $project) {
            /* @var $project Project */
            $output->write("visibility:" . $project->getVisibility());
            $output->write("\tuser:" . $project->getUser()->getUsername());
            $output->writeln("\tname:" . $project->getName());
        }
    }
}
