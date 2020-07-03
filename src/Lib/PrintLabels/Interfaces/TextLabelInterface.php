<?php

namespace App\Lib\PrintLabels\Interfaces;

interface TextLabelInterface extends LabelInterface
{
    /**
     * format function for input data
     *
     * @param  array  $labelData from view
     * @return string
     */
    public function format(\App\Model\Entity\PrintTemplate $printTemplate, array $printData);
    
}