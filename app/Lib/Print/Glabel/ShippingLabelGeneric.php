<?php

App::uses('GlabelInterface', 'Lib/Print/Interface');
App::uses('Label', 'Lib/Print');

class ShippingLabelGeneric extends Label implements GlabelInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function print($printerDetails, $glabelsTemplateFullPath)
    {
        return $this->glabelsBatchPrint($glabelsTemplateFullPath, $printerDetails['Printer']['queue_name']);
    }

    public function format($labelData)
    {
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