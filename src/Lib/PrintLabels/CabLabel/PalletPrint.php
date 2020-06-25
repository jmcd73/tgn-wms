<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\CabLabel;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\Interfaces\TextLabelInterface;
use App\Lib\PrintLabels\Label;
use App\Model\Entity\Printer;
use Cake\Core\Configure;

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

    public function print(Printer $printer)
    {
        $printSettings = $this->getPrintSettings(
            $printer,
            $this->action
        );

        return $this->sendPrint($this->printContent, $printSettings);
    }
}