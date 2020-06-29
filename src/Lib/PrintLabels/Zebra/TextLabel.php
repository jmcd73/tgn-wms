<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Zebra;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\CabLabel\CabLabel;
use App\Lib\PrintLabels\Interfaces\LabelInterface;
use App\Lib\PrintLabels\Label;
use App\Model\Entity\Printer;
use Cake\Core\Configure;

class TextLabel extends Label implements LabelInterface
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function format($printTemplate, $formData)
    {

        $quantity = $formData['quantity'];

        $number = $formData['number'];

        $companyName = $formData['companyName'];

        $offset = strlen($number) === 1 ? '0310' : '0160';

        $templateTokens = json_decode($printTemplate->replace_tokens);

        tog($templateTokens);

        $labelValues = [];

        foreach ($templateTokens as $ttKey => $ttValue) {
            $labelValues[$ttValue] = ${$ttValue};
        }


        $this->printContent = (new CabLabel(
            $labelValues,
            $printTemplate->text_template,
            $templateTokens
        ))->printContent;

        return $this;
    }

    /**
     * 
     * @param mixed $printer 
     * @return array 
     */
    public function print(Printer $printer): array
    {
        return $this->sendPrint($this->printContent, $printer);
    }
}