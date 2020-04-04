<?php

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\GlabelInterface;
use App\Lib\PrintLabels\Label;

class GlabelSample extends Label implements GlabelInterface
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

        $this->formatGlabelSample($labelData);

        return $this;
    }

    /**
     * @param array $printArray Print data array
     * @return void
     */
    public function formatGlabelSample($printArray)
    {
        $this->glabelsMergeCSV = false;
        $this->setPrintCopies($printArray['copies']);
        $this->setPrintContent(null);
    }
}