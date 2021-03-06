<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\GlabelsInterface;
use App\Lib\PrintLabels\Label;

class CrossdockLabel extends Label implements GlabelsInterface
{
    protected $variablePages = true;

    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function print($printerDetails)
    {
        return $this->glabelsBatchPrint($printerDetails);
    }

    public function format($glabelsProject, $labelData)
    {
        $this->setGlabelsTemplate($glabelsProject);
        
        $this->formatCrossdockLabelPrintLine($labelData);

        $this->setPrintContentArray($labelData);

        return $this;
    }

    /**
     * Crossdock Labels
     * @param  array $printArray cakephp array from form with model
     * @return void
     */
    public function formatCrossdockLabelPrintLine($printArray)
    {
        $csvHeadings = [
            'PURCHASE_ORDER',
            'BOOKED_DATE',
            'SENDTO_NAME',
            'SENDTO_ADDR1',
            'SENDTO_ADDR2',
            'TOTAL_PLS',
            'PL_NUM',
            'SENDING_CO',
        ];

        $props = [
            'purchase_order',
            [
                'method' => 'formatLocalDate',
                'field' => 'booked_date',
            ],
            'sending_co',
            [
                'method' => 'splitValueIntoTwoParts',
                'field' => 'address',
            ],
            'sequence-end',
            'sending_co',
        ];

        $printArrayValues = $this->getArrayProperties($printArray, $props);

        $sequenceStart = $printArray['sequence-start'];
        $sequenceEnd = $printArray['sequence-end'];
        $copies = $printArray['copies'];
        $this->glabelsMergeCSV = true;

        $printLines = [];
        $printLines[] = $csvHeadings;

        for ($i = $sequenceStart; $i <= $sequenceEnd; $i++) {
            for ($j = 1; $j <= $copies; $j++) {
                $loopArray = $printArrayValues;
                array_splice($loopArray, 6, 0, $i);
                $printLines[] = $loopArray;
            }
        }

        $printThis = $this->strPutCsv($printLines);

        $this->setPrintContent($printThis);
    }
}