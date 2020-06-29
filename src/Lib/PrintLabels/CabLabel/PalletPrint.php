<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\CabLabel;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\Interfaces\LabelInterface;
use App\Lib\PrintLabels\Label;
use App\Model\Entity\Printer;
use Cake\Core\Configure;

class PalletPrint extends Label implements LabelInterface
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
            throw new MissingConfigurationException('Cannot find print template');
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
        return $this->sendPrint($this->printContent, $printer);
    }
}