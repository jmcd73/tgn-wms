<?php

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\GlabelsInterface;
use App\Lib\PrintLabels\Label;

class ShippingLabelGeneric extends Label implements GlabelsInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function print($printerDetails)
    {
        return $this->glabelsBatchPrint($printerDetails);
    }

    public function format( $glabelsProject, $labelData)
    {
        $this->setGlabelsTemplate($glabelsProject);
        
        $this->setPrintContentArray($labelData);

        $this->formatShippingLabelsGeneric($labelData);

        return $this;
    }

    /**
     * @param array $printArray Print data array
     * @return void
     */
    public function formatShippingLabelsGeneric($printArray)
    {
        $arrayOfProps = [
            'companyName',
            'productName',
            'productDescription',
            'genericLine1',
            'genericLine2',
            'genericLine3',
            'genericLine4',
            'copies',
        ];

        $retArrayOfProps = $this->getArrayProperties($printArray, $arrayOfProps);

        $copies = $printArray['copies'];

        $this->glabelsMergeCSV = true;

        $this->setPrintCopies($copies);

        $printThis = $this->strPutCsv($retArrayOfProps);

        $this->setPrintContent($printThis);
    }
}