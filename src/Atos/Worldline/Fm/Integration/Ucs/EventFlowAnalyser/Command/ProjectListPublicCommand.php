<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Command;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ProjectService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\GraphVizService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\EventService;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ProjectListPublicCommand extends ContainerAwareCommand    
{
    protected function configure()
    {
        $this
        ->setName('analyser:project:list:public')
        ->setDescription('Output all public projects')
        ;        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $projectService ProjectService */
        $projectService = $this->getContainer()->get('app.project');
        
        $projects = $projectService->getAllPublic();
        foreach ($projects as $project) {
            /* @var $project Project */
            $output->write("visibility:" . $project->getVisibility());
            $output->write("\tuser:" . $project->getUser()->getUsername());
            $output->writeln("\tname:" . $project->getName());
        }
    }
}
