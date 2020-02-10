<?php

App::uses('MissingConfigurationException', 'Lib/Exception');
App::uses('CabLabel', 'Lib/Print/CabLabel');
App::uses('Label', 'Lib/Print');
App::uses('TextLabelInterface', 'Lib/Print/Interface');
App::uses('Configure', 'Cake/Core');

class CartonLabel extends Label implements TextLabelInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function format($printTemplate, $formData)
    {
        $printTemplateContents = $printTemplate['text_template'];

        if (empty($printTemplateContents)) {
            throw new MissingConfigurationException('Cannot find print template for ' . $this->action);
        }

        //{ "*DESC*": "description", "*GTIN14*": "gtin14", "*NUM_LABELS*": "numLabels" }

        $description = $formData['description'];
        $gtin14 = $formData['barcode'];
        $numLabels = $formData['count'];

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