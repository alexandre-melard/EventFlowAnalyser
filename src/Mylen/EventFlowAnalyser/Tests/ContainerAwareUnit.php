<?php
namespace Mylen\EventFlowAnalyser\Tests;

// This assumes that this class file is located at:
// src/Application/AcmeBundle/Tests/ContainerAwareUnitTestCase.php
// with Symfony 2.0 Standard Edition layout. You may need to change it
// to fit your own file system mapping.
require_once __DIR__ . '/../../../../../../../../app/AppKernel.php';
require_once __DIR__ . '/../../../../../../../../vendor/mockery/mockery/library/Mockery/Loader.php';
require_once __DIR__ . '/../../../../../../../../vendor/davedevelopment/hamcrest-php/hamcrest/Hamcrest.php';

class ContainerAwareUnit extends \PHPUnit_Framework_TestCase
{
    protected static $kernel;
    protected static $container;

    public static function setUpBeforeClass()
    {
        self::$kernel = new \AppKernel('dev', true);
        self::$kernel->boot();
        self::$container = self::$kernel->getContainer();

        $loader = new \Mockery\Loader;
        $loader->register();
    }

    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }

    public function getParameter($name)
    {
        return self::$kernel->getContainer()->getParameter($name);
    }
}