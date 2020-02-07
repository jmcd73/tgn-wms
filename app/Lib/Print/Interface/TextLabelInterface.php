<?php

interface TextLabelInterface
{
    /**
     * format function for input data
     * @param array $printTemplate template we are using
     * @param array $formData Form data from view
     * @return string
     */
    public function format($printTemplate, $formData);
}