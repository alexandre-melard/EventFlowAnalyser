<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Doctrine\Common\Cache\Cache;

use Doctrine\Common\Cache\ApcCache;
use Monolog\Logger;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\DependencyInjection\CacheAware;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventIn;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\EventOut;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;


class ProjectService extends CacheAware
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
     * @var Filesystem
     */
    private $fs;
    
    /**
     *
     * @param Cache $c
     * @param Logger $l
     * @param string $x
     */
    public function __construct(Cache $c, Logger $l)
    {
        parent::__construct($c);
        $this->logger = $l;
        $this->fs = new Filesystem();
    }
    
    public function setParserService(ParserService $parserService)
    {
        $this->parserService = $parserService;
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
        $finder = new Finder();
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
    
    public function mirror($from, $to, $delete) 
    {
        $this->fs->mirror($from, $to);
        if ($delete) {
            $this->fs->remove($from);
        }
    }
    
    /**
     * Copy documents from projects data dir to $to dir.
     * The documents are renamed to their origin value during the copy.
     * @param Project $project
     * @param string $from
     * @param string $to
     */
    public function dataToTmp(Project $project, $from, $to)
    {
        foreach ($project->getDocuments() as $document) {
            /* @var $document Document */
            $this->fs->copy(
                    $document->getPath(), 
                    $to . DIRECTORY_SEPARATOR . $document->getOriginalName(),
                    true
                    );
        }
    }
    
    public function getDataDir(Project $project, $uploadDir)
    {
        return 
            $uploadDir . 
            '/data/' . 
            $project->getVisibility() . 
            '/' . 
            $project->getUser()->getSalt() . 
            '/' . 
            $project->getKey();
    }
    
    public function getTmpDir(Project $project, $uploadDir)
    {
        return
            $uploadDir .
            '/tmp/' .
            $project->getKey() .
            '/originals';
    }
    
}
