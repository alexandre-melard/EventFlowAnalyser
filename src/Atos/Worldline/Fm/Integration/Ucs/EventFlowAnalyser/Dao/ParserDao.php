<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Parser;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\AbstractDao;

class ParserDao extends AbstractDao
{
    /**
     * Try to retrieve Event from datasource else instanciates one.
     * @param string $type
     */
    public function getParser(Document $document)
    {
        $parser = $this->em
                    ->getRepository('UcsEventFlowAnalyser:Parser')
                    ->findOneBy(
                            array(
                                    'document' => $document->getId()
                            )
                    );
        if (!isset($parser)) {
            $parser = new Parser($document);
        }
    
        return $parser;
    }
    
}
