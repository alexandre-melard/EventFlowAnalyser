<?php
namespace Mylen\EventFlowAnalyser\Service;


use Mylen\UserBundle\Entity\User;

use Mylen\EventFlowAnalyser\Dao\ProjectDao;

use Monolog\Logger;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use FOS\UserBundle\Model\UserManagerInterface;

use Mylen\JQueryFileUploadBundle\Services\FileUploaderService;

use Mylen\EventFlowAnalyser\Entity\EventIn;
use Mylen\EventFlowAnalyser\Entity\EventOut;
use Mylen\EventFlowAnalyser\Entity\Document;
use Mylen\EventFlowAnalyser\Entity\Parser;
use Mylen\EventFlowAnalyser\Entity\Project;


class ProjectService
{
    /**
     * @var Logger
     */
    protected $logger;
    
    /**
     *  @var ParserService 
     */
    private $parserService;
    
    /**
     *  @var FileUploaderService
     */
    private $fileUploaderService;
    
    /**
     *  @var ProjectDao
     */
    private $projectDao;
    
    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * @var GraphVizService
     */
    private $graphService = null;

    /**
     * @var UserManagerInterface 
     */
    private $userManager = null;

    /**
     *
     * @param Logger $l
     * @param string $x
     */
    public function __construct(Logger $l)
    {
        $this->logger = $l;
        $this->fs = new Filesystem();
    }

    /**
     * @param ParserService $parserService
     */
    public function setParserService(ParserService $parserService)
    {
        $this->parserService = $parserService;
    }

    /**
     * @param FileUploaderService $fileUploader
     */
    public function setFileUploaderService(FileUploaderService $fileUploader)
    {
        $this->fileUploaderService = $fileUploader;
    }
    
    /**
     * @param ProjectDao $projectDao
     */
    public function setProjectDao(ProjectDao $projectDao)
    {
        $this->projectDao = $projectDao;
    }
    
    /**
     * Get project from context
     * @param User $user
     * @param string $name
     * @return Project
     */
    public function getProject(User $user, $name)
    {
        return $this->projectDao->get($user, $name);
    }
    
    /**
     * Get all project from context
     * @param User $user
     * @return array Project[]
     */
    public function getAllProject(User $user)
    {
        return $this->projectDao->getAllByUser($user);
    }
    
    /**
     * Get all public projects from context
     * @return array Project[]
     */
    public function getAllPublic()
    {
        return $this->projectDao->getAllByVisibility('public');
    }
    
    /**
     * Get all private projects from context
     * @return array Project[]
     */
    public function getAllPrivate()
    {
        return $this->projectDao->getAllByVisibility('private');
    }
    
    public function generateProjectAllGraph($userName, $projectName, $console=false, $format='dot', $outputFormat='dot', $dir=null)
    {
        $user = $this->userManager->findUserByUsername($userName);

        $project = $this->getProject($user, $projectName);
        
        if (null == $dir) {
            if($console)call_user_func($console, "dir not provided, will write to project directory");
            $dir = $project->getPath() . DIRECTORY_SEPARATOR . 'graphs';
            $fs = new Filesystem();
            if (!$fs->exists($dir)) {
                $fs->mkdir($dir);
            }
            if($console)call_user_func($console, "writing to dir: $dir");
        }
        
        $file = $dir . DIRECTORY_SEPARATOR . $project->getName() . '.' . $outputFormat;
        $out = $this->graphService->generateProjectGraph($project, $format, $outputFormat, $file);
        
        $file = $dir . DIRECTORY_SEPARATOR . $project->getName() . '.' . $outputFormat;
        $total = count($project->getEvents())+1;
        $curr = 0;
        foreach ($project->getEvents() as $event) {
            $file = $dir . DIRECTORY_SEPARATOR . $event->getType() . '.' . $outputFormat;
            $out = $this->graphService->generateProcessGraph($event, $format, $outputFormat, $file);
            if($console)call_user_func($console, '[' . ++$curr . "/$total]\twriting to file: ". basename($file));
        }
        if($console)call_user_func($console, 'done');
    }

    /**
     * Populate the even tree with file data.
     * The documents are setup with tmp file path.
     * The definitive path will be set during the upload process.
     * @throws Exception
     */
    public function populate(Project $project)
    {
        if ($this->parserService === null) {
            throw new Exception("parserService must be set");
        }
        
        /* initialize project */
        $project = $this->init($project);
        
        $finder = Finder::create();
        $finder->in($project->getTmp());
        foreach ($finder as $file) {
            /* @var $file SplFileInfo */
            $document = new Document($file->getPathname());
            $document->setName($file->getBasename('.xml'));
            $document->setProject($project);
            $document->setTmp($project->getPath() . '/' . $file->getBasename());
            $document->setUri($project->getWebPath() . '/' . $file->getBasename());
            $project->addDocument($document);
        }
        $project->setDocuments($this->parserService->parseDocuments($project->getDocuments()));
        
        $this->projectDao->persist($project);
        $this->projectDao->flush();
        
        // clean up tmp dir
        $this->removeDir($project->getTmp());

        // Generate Graphs
        foreach (array('svg', 'png') as $output) {
            $this->generateProjectAllGraph(
                    $project->getUser()->getUsername(),
                    $project->getName(),
                    false,
                    'dot',
                    $output);            
        }
        
        return $project;
    }
    
    public function createDir($path, $delete) 
    {
        // Create data directory if soft is new, clear it if not
        if ($delete && $this->fs->exists($path)) {
            $this->fs->remove($path);
        }
        $this->fs->mkdir($path);

        return $path;
    }
    
    public function removeDir($path)
    {
        $this->fs->remove($path);
    }
    
    public function init(Project $project) 
    {
        $project->setProjectService($this);
        $project->setPath($this->getDataDir($project));
        $project->setWebPath($this->getWebDataDir($project));
        $project->setTmp($this->getTmpDir($project));
        
        return $project;
    }
    
    /**
     * Copy documents from projects data dir to $to dir.
     * The documents are renamed to their origin value during the copy.
     * @param Project $project
     */
    public function dataToTmp(Project $project)
    {
        foreach ($project->getDocuments() as $document) {
            /* @var $document Document */
            $this->fs->copy(
                    $document->getPath(), 
                    $project->getTmp() . DIRECTORY_SEPARATOR . $document->getOriginalName(),
                    true
                    );
        }
    }
    
    public function createTmp(Project $project)
    {
        $uploadDir = $this->fileUploaderService->getFileBasePath();
    
        $fs = new Filesystem();
        if ($project->getKey() === null) {
            do {
                // Build unique ID
                $project->setKey(sha1(uniqid(mt_rand(), true)));
            } while ($fs->exists($uploadDir . '/tmp/' . $project->getKey()));
        }
    
        // Create temporary directory where the user will be able to play with the files
        $project->setTmp($uploadDir . '/tmp/' . $project->getKey());
        $fs->mkdir($project->getTmp());
        $project->setTmp($project->getTmp() . '/originals');
        $fs->mkdir($project->getTmp());
    
        return $project;
    }
    
    public function getDataDir(Project $project)
    {
        $uploadDir = $this->fileUploaderService->getFileBasePath();
        return 
            $uploadDir . 
            '/data/' . 
            $project->getVisibility() . 
            '/' . 
            $project->getUser()->getSalt() . 
            '/' . 
            $project->getKey();
    }
    
    public function getWebDataDir(Project $project)
    {
        $uploadDir = $this->fileUploaderService->getWebBasePath();
        return
        $uploadDir .
        '/data/' .
        $project->getVisibility() .
        '/' .
        $project->getUser()->getSalt() .
        '/' .
        $project->getKey();
    }
    
    public function getTmpDir(Project $project)
    {
        $uploadDir = $this->fileUploaderService->getFileBasePath();
        return
            $uploadDir .
            '/tmp/' .
            $project->getKey() .
            '/originals';
    }

    public function setGraphService($graphService) {
        $this->graphService = $graphService;
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager) {
        $this->userManager = $userManager;
    }


}
