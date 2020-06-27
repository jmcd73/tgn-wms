<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\CabLabel;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\Interfaces\TextLabelInterface;
use App\Lib\PrintLabels\Label;
use App\Model\Entity\Printer; ;

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

    public function print(Printer $printer)
    {
        return $this->sendPrint($this->printContent, $printer);
    }
}