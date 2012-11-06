<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexandre Melard <alexandre.melard@atos.net>
 * Date: 24/10/12
 * Time: 17:27
 * FileService class provides utility functions to work with parser xml files .
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service;

class FileService
{
    public static function scanDirIterator(\DirectoryIterator $entries) {

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
     * data -> salt -> public ->    app -> file1.xml
     *                                  -> file2.xml
     *                                  -> ...
     *              -> private ->   app -> file1.xml
     *                                  -> file2.xml
     *                                  -> ...
     * @param $dir mixed path to xml directory
     * @return array
     * @throws \RuntimeException
     */
    public static function scanDir($dir)
    {
        if (!is_dir($dir)) {
            throw new \RuntimeException('Directory does not exists: [' . $dir . ']');
        }
        return FileService::scanDirIterator(new \DirectoryIterator($dir));
    }
}
