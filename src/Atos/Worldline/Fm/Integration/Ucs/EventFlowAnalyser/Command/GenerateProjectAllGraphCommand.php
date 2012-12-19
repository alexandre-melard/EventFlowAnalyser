<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Command;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\GraphVizService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class GenerateProjectAllGraphCommand extends ContainerAwareCommand    
{
    public function configure()
    {
        $this
        ->setName('analyser:graph:project:all')
        ->setDescription('Generate all graphs for a project')
        ->addArgument('user', InputArgument::REQUIRED, 'User')
        ->addArgument('project', InputArgument::REQUIRED, 'Project')
        ->addOption('dir', null, InputOption::VALUE_REQUIRED, 'Output Dir')
        ->addOption('format', null, InputOption::VALUE_REQUIRED, 'Output Format (dot, neato, circo, dpf.', 'dot')
        ->addOption('output', null, InputOption::VALUE_REQUIRED, 'Output Format (svg, png, jpg, etc.', 'svg')
        ;        
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $userName = $input->getArgument('user');
        $projectName = $input->getArgument('project');
        $format = $input->getOption('format');
        $outputFormat = $input->getOption('output');
        $dir = $input->getOption('dir');
        
        /* @var $projectService ProjectService */
        $projectService = $this->getContainer()->get('app.project');

        $projectService->generateProjectAllGraph($userName, $projectName, array($output, 'writeln'), $format, $outputFormat, $dir);
    }
}
