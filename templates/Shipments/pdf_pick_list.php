<?php
use App\Lib\Pdf\XTCPDF;

$pdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$shipper = $shipment['shipper'];

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor($appName);

$pdf->SetTitle($shipper);

$pdf->SetSubject('Pick List for ' . $shipper);

array_push($keywords, $appName, $shipper);

$pdf->SetKeywords(join(' ', $keywords));

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->addPage();

$pdf->SetFont('helvetica', '', 13, '', 'false');

$style = ['width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [0, 0, 0]];
$style = ['width' => 0.4];
$xAdjust = 1;

$pdf->drawHeader($xAdjust, -2, $style);

$pdf->headerDetail(__('Shipment No'), $shipment['shipper']);
$pdf->headerDetail(__('Destination'), $shipment['destination']);
$pdf->headerDetail(__('Created'), $this->Time->format($shipment['created']));

$pdf->drawHeader($xAdjust, -3, $style, true);

if (!empty($pallets)) :
        $pdf->Cell(145, 0, __('Total Pallets') . ':', 0, 0, 'R', 0, '', 0);
        $pdf->Cell(15, 0, $pl_count, 0, 1, 'R', 0, '', 0);

        $pdf->drawHeader(1, -2, $style, true);
        $pdf->Cell(40, 0, 'Item Code', 0, 0, 'L', 0, '', 0);
        $pdf->Cell(135, 0, 'Total', 0, 1, 'R', 0, '', 0);

       $pdf->rowDetail([
           'col-1' => 'Description',
           'col-2' => 'Location',
           'col-3' => 'Reference',
           'col-4' => 'Qty',
           'col-5' => 'Pallets',
           'col-6' => 'Qty',
       ]);
        $pdf->doubleLine();
    foreach ($groups as $group) :
            //string str_pad ( string $input , int $pad_length [, string $pad_string = " " [, int $pad_type = STR_PAD_RIGHT ]] )

           $pdf->Cell(40, 0, $group['code'], 0, 1, 'L', 0, '', 0);
           // $pdf->Write(0, '  ' . $group['code'], '', 0, 'L', true, 0, false, false, 0);
           $pdf->Cell(120, 0, $group['description'], 0, 0, 'L', 0, '', 0);

           $pdf->Cell(40, 0, $group['pallet_count'], 0, 0, 'R', 0, '', 0);
           $pdf->Cell(15, 0, $group['total'], 0, 1, 'R', 0, '', 0);

            //str_repeat(' ', 9) . str_pad($group['0']['Pallets'], 12, ' ', STR_PAD_LEFT) . str_repeat(' ', 3) . str_pad($group['0']['Total'], 5, ' ' , STR_PAD_LEFT)

        foreach ($pallets as $pallet) :
            if ($pallet['item_id'] == $group['item_id']) :
                    $pdf->rowDetail([
                        'col-1' => '',
                        'col-2' => $pallet['location']['location'],
                        'col-3' => $pallet['pl_ref'],
                        'col-4' => $pallet['qty'],
                        'col-5' => '',
                        'col-6' => '',
                    ]);
            endif;
        endforeach;

            $pdf->drawHeader(1, -2, ['width' => 0.3], true);
    endforeach;

        $pdf->Cell(0, 0, 'End of Shipment Pick List', 0, 1, 'C', 0, '', 0);

        //$pdf->Write(0, $doubleDivider, '', 0, 'L', true, 0, false, false, 0);
        $pdf->doubleLine();
else :
        $pdf->Cell(0, 0, 'Please put some pallets on this shipment', 0, 1, 'C', 0, '', 0);

        $pdf->doubleLine();
endif;

    // use the examples at http://tcpdf.org to create a pdf

$pdf->Output($file_name, 'I');