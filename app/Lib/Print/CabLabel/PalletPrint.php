<?php

App::uses('MissingConfigurationException', 'Lib/Exception');
App::uses('CabLabel', 'Lib/Print/CabLabel');
App::uses('Label', 'Lib/Print');
App::uses('TextLabelInterface', 'Lib/Print/Interface');
App::uses('Configure', 'Cake/Core');

class PalletPrint extends Label implements TextLabelInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function format($printTemplate, $labelValues)
    {
        $printTemplateContents = $printTemplate['text_template'];
        $templateTokens = json_decode($printTemplate['replace_tokens']);

        $companyName = Configure::read('companyName');

        if (empty($printTemplateContents) || empty($templateTokens)) {
            throw new MissingConfigurationException('Cannot find print template for bigNumber');
        }

        $this->setReference($labelValues['reference']);

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