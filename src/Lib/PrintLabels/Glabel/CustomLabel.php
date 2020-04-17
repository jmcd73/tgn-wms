<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\GlabelInterface;
use App\Lib\PrintLabels\Label;

class CustomLabel extends Label implements GlabelInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function print($printerDetails, $glabelsProject)
    {
        return $this->glabelsBatchPrint($glabelsProject, $printerDetails['queue_name']);
    }

    public function format($labelData)
    {
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
        $printThis = '';

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