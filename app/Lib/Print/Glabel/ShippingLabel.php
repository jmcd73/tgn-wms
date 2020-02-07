<?php

App::uses('GlabelInterface', 'Lib/Print/Interface');
App::uses('Label', 'Lib/Print');

class ShippingLabel extends Label implements GlabelInterface
{
    protected $variablePages = true;

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

        $this->formatShippingLabelPrintLine($labelData);

        return $this;
    }

    /**
     * formatShippingLabelPrintLine
     * @param array $printArray Print data array
     * @return void
     */
    public function formatShippingLabelPrintLine($printArray)
    {
        $sequenceStart = $printArray['sequence-start'];
        $sequenceEnd = $printArray['sequence-end'];
        $copies = $printArray['copies'];

        $this->glabelsMergeCSV = true;

        $reference = $printArray['reference'];
        $state = $printArray['state'];

        $lookUpProps = [
            'BLANK',
            ['insertNewLineAtComma', 'address'],
            'reference',
            'state',
            'sequence-end',
        ];

        $props = $this->getArrayProperties($printArray, $lookUpProps);

        $printLines = [];

        for ($i = $sequenceStart; $i <= $sequenceEnd; $i++) {
            for ($j = 1; $j <= $copies; $j++) {
                $loopArray = $props;
                array_splice($loopArray, 4, 0, $i);
                $printLines[] = $loopArray;
            }
        }

        $printThis = $this->strPutCsv($printLines);

        $this->setPrintContent($printThis);
    }
}