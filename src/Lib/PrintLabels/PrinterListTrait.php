<?php

namespace App\Lib\PrintLabels;

trait PrinterListTrait
{
    /**
     * Get Local Printer List
     * @return mixed
     */
    public function getLocalPrinterList()
    {
        ob_start();
        passthru('lpstat -a');
        $lpstatResult = ob_get_contents();
        ob_end_clean(); //Use this instead of ob_flush()

        $printerLine = array_filter(explode("\n", $lpstatResult));

        $printerList = [];

        foreach ($printerLine as $printer) {
            $printerList[] = explode(' ', $printer)[0];
        }

        return array_combine($printerList, $printerList);
    }
}