<?php

    //debug(App::objects('Vendor'));
    //App::import('Vendor','TCPDF', [ 'file' => 'tecnickcom/tcpdf/tcpdf.php']);

    class XTCPDF extends TCPDF
    {

        public function Header()
        {
            // Logo
            $image_file = IMAGES . Configure::read('footer.img');

            switch (exif_imagetype($image_file)) {
                case IMAGETYPE_JPEG:
                    $imageType = 'JPG';
                    break;
                case IMAGETYPE_PNG:
                    $imageType = 'PNG';
                    break;
                default:
                    throw new NotFoundException("Footer image type unknown");
            };

            $this->Image($image_file, 10, 10, 60, '', $imageType, '', 'B', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 12);
            // Title
            // Cell( $w, $h = 0, $txt = '',
            // $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M' )
            $this->Cell(60, 15, 'Shipment Pick List', 0, false, 'C', 0, '', 0, false, 'M', 'T');

        }

        public function Footer()
        {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    $pdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Toggen IT Services');
    $pdf->SetTitle($shipment['Shipment']['shipper']);
    $pdf->SetSubject('Pick List');
    $pdf->SetKeywords('Pick List, ' . $shipment['Shipment']['shipper'] . ',"100PBC WMS"');

    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    /*
    Write( $h, $txt, $link = '', $fill = false, $align = '', $ln = false, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0, $wadj = 0, $margin = '' )
     */

    $pdf->addPage();

    $pdf->SetFont('courier', '', 13, '', 'false');

    $doubleDivider = '===============================================================';
    $singleDivider = '---------------------------------------------------------------';

    $pdf->Write(0, $doubleDivider, '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, str_pad(__('Shipment No') . ': ' . h($shipment['Shipment']['shipper']), 33, ' ', STR_PAD_RIGHT), '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, str_pad(__('Destination') . ': ' . h($shipment['Shipment']['destination']), 33, ' ', STR_PAD_RIGHT), '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, str_pad(__('Created') . ': ' . $this->Time->format('d/m/Y h:iA', $shipment['Shipment']['created']), 30, ' ', STR_PAD_RIGHT), '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, $doubleDivider, '', 0, 'L', true, 0, false, false, 0);

    if (!empty($pallets)):

        $pdf->Write(
            0,
            str_pad(__('Total Pallets:') . h($pl_count), 30, ' ', STR_PAD_LEFT),
            '',
            0,
            'L',
            true,
            0,
            false, false, 0);
        $pdf->Write(0, $doubleDivider, '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '  Item Code                                             Total', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '  Description   Location   Reference    Qty   Pallets   Qty', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '  -----------   --------   ---------    ---   -------   -----', '', 0, 'L', true, 0, false, false, 0);

        foreach ($groups as $group):
            //string str_pad ( string $input , int $pad_length [, string $pad_string = " " [, int $pad_type = STR_PAD_RIGHT ]] )
            $pdf->Write(0, '  ' . $group['Item']['code'], '', 0, 'L', true, 0, false, false, 0);
            $palletDescription = '  ' . str_pad($group['Item']['description'], 30, ' ', STR_PAD_RIGHT);
            $palletsCartons = str_repeat(' ', 9) . str_pad($group['0']['Pallets'], 12, ' ', STR_PAD_LEFT) . str_repeat(' ', 3) . str_pad($group['0']['Total'], 5, ' ', STR_PAD_LEFT);
            $concatDescCount = $palletDescription . $palletsCartons;
            $pdf->Write(0, $concatDescCount, '', 0, 'L', true, 0, false, false, 0);
            //str_repeat(' ', 9) . str_pad($group['0']['Pallets'], 12, ' ', STR_PAD_LEFT) . str_repeat(' ', 3) . str_pad($group['0']['Total'], 5, ' ' , STR_PAD_LEFT)

            foreach ($pallets as $pallet):
                if ($pallet['Pallet']['item_id'] == $group['Pallet']['item_id']):
                    $pdf->Write(0,
                        str_pad($pallet['Location']['location'], 24, ' ', STR_PAD_LEFT) . '    ' . $pallet['Pallet']['pl_ref'] . '     ' . $pallet['Pallet']['qty'],
                        '', 0, 'L', true, 0, false, false, 0);

                endif;
            endforeach;
            $pdf->Write(0, $singleDivider, '', 0, 'L', true, 0, false, false, 0);

        endforeach;
        $pdf->Write(0, '                  End of Shipment Pick List', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, $doubleDivider, '', 0, 'L', true, 0, false, false, 0);

    else:

        $pdf->Write(0, '             Please put some pallets on this shipment', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, $doubleDivider, '', 0, 'L', true, 0, false, false, 0);

    endif;

    // use the examples at http://tcpdf.org to create a pdf

$pdf->Output($file_name, 'I');
