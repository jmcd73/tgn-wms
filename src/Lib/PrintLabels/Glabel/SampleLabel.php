<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\GlabelsInterface;
use App\Lib\PrintLabels\Label;

class SampleLabel extends Label implements GlabelsInterface
{
    protected $mergeFields = [
        'productName',
        'batch',
        'manufactureDate',
        'bestBefore',
        'comment',
    ];

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

        $this->setPrintContentArray($labelData);
        
        $this->formatSampleLabel($labelData);

        return $this;
    }

    /**
     * @param  array $printArray print array
     * @return void
     */
    public function formatSampleLabel($printArray)
    {
        //"Product name","Product Batch","01/09/2018","04/09/2018","Product Comment Here 36 Characters"

        $returnedProps = $this->getArrayProperties($printArray, $this->mergeFields);

        $this->setPrintCopies($printArray['copies']);

        $this->glabelsMergeCSV = true;

        $printThis = $this->strPutCsv($returnedProps);

        $this->setPrintContent($printThis);
    }
}