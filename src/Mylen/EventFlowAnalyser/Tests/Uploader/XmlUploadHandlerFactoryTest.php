<?php
namespace Mylen\EventFlowAnalyser\Uploader;

use Mylen\EventFlowAnalyser\Tests\ContainerAwareUnit;

use Mylen\JQueryFileUploadBundle\Services\IUploadHandlerFactory;

use Mylen\EventFlowAnalyser\Uploader\XmlUploadHandler;
use Mockery as m;

class XmlUploadHandlerFactoryTest extends ContainerAwareUnit
{
    public function testIndex()
    {
        $factory = new XmlUploadHandlerFactory($this->getParameter('app.event_xsd'));
        $this->assertNotNull($factory);

        /* Used by the UploadHandler construct function */
        $_SERVER['SCRIPT_FILENAME'] = 'test';
        $_SERVER['SERVER_NAME'] = 'test';
        $_SERVER['SERVER_PORT'] = '123';
        
        $uploader = $factory->createUploadHandler(array(), false);
        $this->assertNotNull($uploader);
        
    }
}
