<?php

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\LabelInterface;
use App\Lib\PrintLabels\Label;

class SsccLabel extends Label implements LabelInterface
{
    /**
     *   $cabLabelData = [
                'companyName' => $companyName,
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
        'BRAND' => 'brand',
        'VARIANT' => 'variant',
        'QUANTITY_DESCRIPTION' => 'quantity_description',
    ];

    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function print($printer)
    {
        return $this->glabelsBatchPrint($printer);
    }

    public function format($template, $labelData)
    {
        tog("TEMPLATE", $template, $labelData);
        $this->setGlabelsTemplate($template);
        $this->setPrintContentArray($labelData);
        $this->setReference($labelData['reference']);
        $this->setBatch($labelData['batch']);
        $this->setItemCode($labelData['internalProductCode']);

        $printArrayValues = $this->getArrayProperties($labelData, array_values($this->headings));

        $copies = $labelData['numLabels'];

        $this->glabelsMergeCSV = true;

        $printLines = [];

        $printLines[] = array_keys($this->headings);

        $printLines[] = $printArrayValues;

        $printThis = $this->strPutCsv($printLines);

        $this->setPrintCopies($copies);

        $this->setPrintContent($printThis);

        return $this;
    }
}