<?php
/**
 * User: A140980
 * Date: 17/11/12
 * Time: 23:22
 * Extends basic uploader to add xsd validation.
 */
namespace Mylen\EventFlowAnalyser\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class XmlUploadHandlerTest extends WebTestCase
{
    public function testValidate()
    {
        $client = static::createClient(array(), array(
                        'HTTP_HOST' => 'analyser.localhost',
                        'PHP_AUTH_USER' => 'alex',
                        'PHP_AUTH_PW'   => 'alex',
        ));
        
        $uploadDir = $client->getContainer()->getParameter('file_uploader.file_base_path');        
        $fileName = $uploadDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'dbu.xml';
        $file = new UploadedFile(
                $fileName,
                'dbu.xml',
                'xml',
                @filesize($fileName)
        );

        $_SERVER['CONTENT_LENGTH'] = $file->getSize();
        $_SERVER['CONTENT_TYPE'] = 'multipart/form-data';

//         $files = array(
//             'name' => $file->getClientOriginalName(),
//             'type' => $file->getMimeType(),
//             'tmp_name' => $file->getPathname(),
//             'size' => $file->getSize(),
//         );
//         $_FILES['files'] = $files;
        
//         $client->request(
//                 'POST',
//                 'projects/upload/tests',
//                 array(),
//                 array('file' => $file),
//                 array(),
//                 file_get_contents($fileName)
//         );
        
//         $response = $client->getResponse();
    }

}
