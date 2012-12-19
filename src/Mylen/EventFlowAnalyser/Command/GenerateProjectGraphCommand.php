<?php
namespace Mylen\EventFlowAnalyser\Command;

use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class GenerateProjectGraphCommand extends ContainerAwareCommand    
{
    protected function configure()
    {
        $this
        ->setName('analyser:graph:project')
        ->setDescription('Generate graph for an event')
        ->addArgument('user', InputArgument::REQUIRED, 'User')
        ->addArgument('project', InputArgument::REQUIRED, 'Project')
        ->addArgument('file', InputArgument::OPTIONAL, 'Output File')
        ;        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userName = $input->getArgument('user');
        $projectName = $input->getArgument('project');
        
        /* @var $projectService ProjectService */
        $projectService = $this->getContainer()->get('app.project');

        /* @var $graphService GraphVizService */
        $graphService = $this->getContainer()->get('app.graph');
        
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($userName);
        
        
        $project = $projectService->getProject($user, $projectName);
        $out = $graphService->generateProjectGraph($project);
        
        
        $file = $input->getArgument('file');
        if (null == $file) {
           $file = $project->getPath() . DIRECTORY_SEPARATOR . 'graphs' . DIRECTORY_SEPARATOR . $project->getName() . '.svg';
        }
        $fs = new Filesystem();
        if (!$fs->exists(dirname($file))) {
            $fs->mkdir(dirname($file));
        }
        $output->writeln('writing to file: ' . $file);
        $handle = fopen($file, 'w');
        fwrite($handle, $out);
        fclose($handle);
        $output->writeln('done');
    }
}
