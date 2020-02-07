<?php

App::uses('GlabelInterface', 'Lib/Print/Interface');
App::uses('Label', 'Lib/Print');

class CustomLabel extends Label implements GlabelInterface
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

        $this->formatCustomLabel($labelData);

        return $this;
    }

    /**
     * @param array $printArray Print Array
     * @return void
     */
    public function formatCustomLabel($printArray)
    {
        $printThis = null;

        $copies = $printArray['copies'];

        if (isset($printArray['csv']) && is_array($printArray['csv'])) {
            $printThis = $this->strPutCsv($printArray['csv']);

            $this->glabelsMergeCSV = true;
        } else {
            $this->glabelsMergeCSV = false;
        }
        $this->setPrintCopies($copies);
        $this->setPrintContent($printThis);
    }
}