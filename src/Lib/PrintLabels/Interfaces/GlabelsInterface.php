<?php

namespace App\Lib\PrintLabels\Interfaces;

interface GlabelsInterface extends LabelInterface
{
    /**
     * format function for input data
     *
     * @param  array  $labelData from view
     * @return string
     */
    public function format(\App\Lib\PrintLabels\Glabel\GlabelsProject $printTemplate, array $printData);
    
}