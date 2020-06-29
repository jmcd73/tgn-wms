<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\LabelInterface;
use App\Lib\PrintLabels\Label;

class CustomLabel extends Label implements LabelInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function print($printerDetails)
    {
        return $this->glabelsBatchPrint($printerDetails);
    }

    public function format($template, $labelData)
    {
        
        $this->setGlabelsTemplate($template);

        $this->setPrintContentArray($labelData);

        $this->formatCustomLabel($labelData);

        return $this;
    }

    /**
     * @param  array $printArray Print Array
     * @return void
     */
    public function formatCustomLabel($printArray)
    {
        $printThis = 'bogus data needed to get a print happening';

        $copies = $printArray['copies'];

        if (isset($printArray['csv'])) {
            $printThis = $printArray['csv'];
            $this->glabelsMergeCSV = true;
        } else {
            $this->glabelsMergeCSV = false;
        }
        $this->setPrintCopies($copies);

        $this->setPrintContent($printThis);
    }
}