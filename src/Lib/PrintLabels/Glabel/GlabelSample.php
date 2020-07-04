<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\PrintLabels\Interfaces\GlabelsInterface;
use App\Lib\PrintLabels\Label;

class GlabelSample extends Label implements GlabelsInterface
{
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

        $this->formatGlabelSample($labelData);

        return $this;
    }

    /**
     * @param  array $printArray Print data array
     * @return void
     */
    public function formatGlabelSample($printArray)
    {
        $this->glabelsMergeCSV = false;
        $this->setPrintCopies($printArray['copies']);
    }
}