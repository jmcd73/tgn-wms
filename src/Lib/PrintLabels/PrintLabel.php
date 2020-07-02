<?php

namespace App\Lib\PrintLabels;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use App\Lib\Utility\FormatDateTrait;
use App\Lib\Utility\SettingsTrait;
use App\Lib\PrintLabels\Glabel\GlabelsProject;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use App\Controller\PalletsController;

class PrintLabel implements EventListenerInterface
{
    use FormatDateTrait, SettingsTrait;

    public function implementedEvents(): array
    {
        return ['PrintLabels.palletPrint' => 'labelPrint'];
    }

    public function labelPrint(Event $event, $item, $printer, $company, $action)
    {
        $pallet = $event->getSubject();

        $bestBeforeDates = $this->formatLabelDates(new FrozenTime($pallet->bb_date));

        $labelCopies = $this->getLabelCopies($item->pallet_label_copies);

        $cabLabelData = [
            'companyName' => $company,
            'internalProductCode' => $item->code,
            'reference' => $pallet->pl_ref,
            'sscc' => $pallet->sscc,
            'description' => $item->description,
            'gtin14' => $item->trade_unit,
            'quantity' => $pallet->qty,
            'bestBeforeHr' => $bestBeforeDates['bb_hr'],
            'bestBeforeBc' => $bestBeforeDates['bb_bc'],
            'batch' => $pallet->batch,
            'numLabels' => $labelCopies,
            'ssccBarcode' => '[00]' . $pallet->sscc,
            'itemBarcode' => '[02]' . $item->trade_unit .
                '[15]' . $bestBeforeDates['bb_bc'] . '[10]' .  $pallet->batch .
                '[37]' . $pallet->qty,
            'brand' =>  $item->brand,
            'variant' =>  $item->variant,
            'quantity_description' =>  $item->quantity_description,
        ];

        $printClass = $item->print_template->print_class;

        if ($item->print_template->is_file_template) {
            $glabelsRoot = $this->getSetting('TEMPLATE_ROOT');
            $template = new GlabelsProject($item->print_template, $glabelsRoot);
        } else {
            $template = $item->print_template;
        }

        $labelClass = LabelFactory::create($printClass, $action)
            ->format($template, $cabLabelData);

        $printResult = $labelClass->print($printer, $template);

        return compact('printResult' , 'labelClass'); 
    }

    /**
     * getLabelCopies
     * @param mixed $labelCopies 
     * @return int 
     */
    public function getLabelCopies(int $labelCopies): int
    {
        $copies =  $labelCopies > 0 ? $labelCopies : $this->getSetting('SSCC_DEFAULT_LABEL_COPIES');

        return (int) $copies;
    }
}
