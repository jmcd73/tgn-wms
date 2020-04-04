<?php

namespace App\Lib\PrintLabels\Zebra;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\CabLabel\CabLabel;
use App\Lib\PrintLabels\Interfaces\TextLabelInterface;
use App\Lib\PrintLabels\Label;
use Cake\Core\Configure;

class TextLabel extends Label implements TextLabelInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function format($printTemplate, $formData)
    {
        $printTemplateContents = $printTemplate['text_template'];

        $companyName = Configure::read('companyName');

        if (empty($printTemplateContents)) {
            throw new MissingConfigurationException('Cannot find print template for bigNumber');
        }

        $quantity = $formData['quantity'];

        $number = $formData['number'];

        $offset = strlen($number) === 1 ? '0310' : '0160';

        $templateTokens = json_decode($printTemplate['replace_tokens']);

        $labelValues = [];

        foreach ($templateTokens as $ttKey => $ttValue) {
            $labelValues[$ttValue] = $$ttValue;
        }

        $this->printContent = (new CabLabel(
            $labelValues,
            $printTemplateContents,
            $templateTokens
        ))->printContent;

        return $this;
    }

    public function print(array $printer)
    {
        $printSettings = $this->getPrintSettings(
            $printer,
            $this->action
        );

        return $this->sendPrint($this->printContent, $printSettings);
    }
}