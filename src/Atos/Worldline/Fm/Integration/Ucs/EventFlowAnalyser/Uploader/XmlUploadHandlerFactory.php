<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Uploader;

use Mylen\JQueryFileUploadBundle\Services\IUploadHandlerFactory;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Uploader\XmlUploadHandler;

class XmlUploadHandlerFactory implements IUploadHandlerFactory
{
    protected $xsd;
    
    public function __construct($xsd) {
        $this->xsd = $xsd;
    }
    
    public function createUploadHandler($options, $initialize) {
        $uh = new XmlUploadHandler($options, $initialize);
        $uh->setXsd($this->xsd);
        return $uh;
    }
}
