<?php

interface GlabelInterface
{
    /**
     * format function for input data
     * @param array $labelData from view
     * @return string
     */
    public function format(array $labelData);
}