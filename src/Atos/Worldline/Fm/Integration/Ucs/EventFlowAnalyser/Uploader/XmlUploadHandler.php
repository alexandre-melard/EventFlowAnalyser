<?php
/**
 * User: A140980
 * Date: 17/11/12
 * Time: 23:22
 * Extends basic uploader to add xsd validation.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Uploader;

use Mylen\JQueryFileUploadBundle\Services\IResponseContainer;

use Mylen\JQueryFileUploadBundle\Services\UploadHandler;

class XmlUploadHandler extends UploadHandler
{
    protected $xsd;
    protected $error;

    protected function validate($uploaded_file, $file, $error, $index)
    {
        if (!parent::validate($uploaded_file, $file, $error, $index)) {
            return false;
        }
        else if (!$this->validateSchema($uploaded_file)) {
            $file->error = $this->error;
            return false;
        }
        return true; 
    }

    /** Validate xml file regarding xsd
     * @param $file
     * @param $schema
     * @return bool
     * @throws Exception
     */
    protected function validateSchema($file)
    {
        $dom = new \DOMDocument("1.0");
        try {
            $validate = $dom->load($file);
        } catch (\ErrorException $e) {
            $this->error = "XML mal formated, check xml format.";
            return false;
        }    
        if (!$dom->schemaValidate($this->xsd)) {
            $this->error = "XSD Validation Error, check xml format against eventXsd.";
            return false;
        }
        return true;
    }
    
    public function setXsd($xsd)
    {
        $this->xsd = $xsd;
    }

}
