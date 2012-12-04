<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * FileService class provides utility functions to work with parser xml files .
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service;

use Symfony\Component\Finder\Finder;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\DependencyInjection\CacheAware;
use Monolog\Logger;

class FileService extends CacheAware
{
    /* @var $logger Logger */
    protected $logger;
    
    /**
     * @param Cache $c
     */
    public function __construct($c, $l)
    {
        parent::__construct($c);
        $this->logger = $l;
    }
    
    public function getFiles($dir, $visibility, $salt, $soft) {

        $path = "$dir/$visibility";
        if ($visibility == 'private') {
            $path .= '/' . $salt;
        }
        
        $finder = new Finder();
        $finder->name('*.xml')->in($path)->name($soft);
        
        $files = array();
        foreach ($finder->files() as $file) {
            $files[] = $file->getPathname();
        }        
        
        return $files;
    }
    
    public function scanDirIterator(\DirectoryIterator $entries) {

        // returned array
        $result = array();

        foreach ($entries as $entry) {
            if ($entry->isDir() and !$entry->isDot()) {
                $result[$entry->getFilename()] = FileService::scanDirIterator(new \DirectoryIterator($entry->getPathname()));
            }
            if ($entry->getExtension() === "xml") {
                $result[] = $entry->getFilename();
            }
        }
        return $result;
    }

    /**
     * data -> public  -> salt ->   app -> file1.xml
     *                                  -> file2.xml
     *                                  -> ...
     *      -> private -> salt ->   app -> file1.xml
     *                                  -> file2.xml
     *                                  -> ...
     * @param $dir mixed path to xml directory
     * @return array
     * @throws \RuntimeException
     */
    public function scanDir($dir)
    {
        if (!is_dir($dir)) {
            throw new \RuntimeException('Directory does not exists: [' . $dir . ']');
        }
        return FileService::scanDirIterator(new \DirectoryIterator($dir));
    }
}
