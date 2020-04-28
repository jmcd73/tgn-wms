<?php

App::uses('GlabelInterface', 'Lib/Print/Interface');
App::uses('Label', 'Lib/Print');

class SsccLabel extends Label implements GlabelInterface
{
    /**
     *   $cabLabelData = [
                'companyName' => Configure::read('companyName'),
                'internalProductCode' => $palletRecord['Item']['code'],
                'reference' => $palletRecord['Pallet']['pl_ref'],
                'sscc' => $palletRecord['Pallet']['sscc'],
                'description' => $palletRecord['Item']['description'],
                'gtin14' => $palletRecord['Pallet']['gtin14'],
                'quantity' => $palletRecord['Pallet']['qty'],
                'bestBeforeHr' => $palletRecord['Pallet']['best_before'],
                'bestBeforeBc' => $this->formatYymmdd($palletRecord['Pallet']['bb_date']),
                'batch' => $palletRecord['Pallet']['batch'],
                'numLabels' => $this->request->data['Pallet']['copies'],
                'ssccGlabels' =>
            ];
     */
    private $headings = [
        'DATE' => 'printDate',
        'ITEMCODE' => 'internalProductCode',
        'BB_BC' => 'bestBeforeBc',
        'BB_HR' => 'bestBeforeHr',
        'DESCRIPTION' => 'description',
        'GTIN14_HR' => 'gtin14',
        'QUANTITY' => 'quantity',
        'PLREF' => 'reference',
        'SSCC' => 'sscc',
        'BATCH' => 'batch',
        'COUNT' => 'numLabels',
        'CONCAT_BC' => 'itemBarcode',
        'SSCC_BC' => 'ssccBarcode', // [00]999999999999999995
        'PRINTER' => 'printer',
        'COMPANY_NAME' => 'companyName',
    ];

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

        $printArrayValues = $this->getArrayProperties($labelData, array_values($this->headings));

        $copies = $labelData['numLabels'];

        $this->glabelsMergeCSV = true;

        $printLines = [];

        $printLines[] = array_keys($this->headings);

        for ($j = 1; $j <= $copies; $j++) {
            $printLines[] = $printArrayValues;
        }

        $printThis = $this->strPutCsv($printLines);

        $this->setPrintCopies(1);

        $this->setPrintContent($printThis);

        return $this;
    }
}