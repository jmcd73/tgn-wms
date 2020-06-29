<?php

namespace App\Lib\PrintLabels\Interfaces;

interface LabelInterface
{
    /**
     * format function for input data
     *
     * @param  array  $labelData from view
     * @return string
     */
    public function format($printTemplate, $printData);

    public function print(\App\Model\Entity\Printer $printer);
}