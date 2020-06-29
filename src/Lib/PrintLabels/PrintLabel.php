<?php

namespace App\Lib\PrintLabels;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;

class PrintLabel implements EventListenerInterface
{

    public function implementedEvents(): array
    {
        return ['PrintLabels.palletPrint' => 'labelPrint'];
    }

    public function labelPrint(Event $event, $item)
    {

        tog("Label Printed", $item);
        
        $pallet = $event->getSubject();


        /* 
           $labelCopies = $this->getLabelCopies($item_detail->pallet_label_copies);

        $printTemplateId = $item_detail['print_template_id'];
        
        $cabLabelData = [
            'companyName' => $this->companyName,
            'internalProductCode' => $item_detail['code'],
            'reference' => $pallet_ref,
            'sscc' => $sscc,
            'description' => $item_detail['description'],
            'gtin14' => $item_detail['trade_unit'],
            'quantity' => $qty,
            'bestBeforeHr' => $bestBeforeDates['bb_hr'],
            'bestBeforeBc' => $bestBeforeDates['bb_bc'],
            'batch' => $data['batch_no'],
            'numLabels' => $labelCopies,
            'ssccBarcode' => '[00]' . $sscc,
            'itemBarcode' => '[02]' . $item_detail['trade_unit'] .
                '[15]' . $bestBeforeDates['bb_bc'] . '[10]' .  $data['batch_no'] .
                '[37]' . $qty,
            'brand' =>  $item_detail['brand'],
            'variant' =>  $item_detail['variant'],
            'quantity_description' =>  $item_detail['quantity_description'],
        ];

        $this->loadModel('PrintLog');

        if ($item_detail->print_template->is_file_template) {

            $template = $this->PrintLog->getGlabelsProject(
                $item_detail->print_template->id
            );
            $printResult = LabelFactory::create($template->details->print_class, $this->request->getParam('action'))
                ->format($cabLabelData)
                ->print($printer, $template);

            $template = $template->details;
        } else {

            $template = $item_detail->print_template;

            $printResult = LabelFactory::create($template->print_class, $this->request->getParam('action'))
                ->format($template, $cabLabelData)
                ->print($printer);
        }

        $isPrintDebugMode = Configure::read('pallet_print_debug');

        $this->handleResult(
            $printResult,
            $printer,
            $pallet_ref,
            $palletData,
            $isPrintDebugMode,
            $data['refer']
        );

 */
    }
}
