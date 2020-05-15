<?php
declare(strict_types=1);

namespace App\Lib\Pdf;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use TCPDF;

class XTCPDF extends TCPDF
{
    public $lineStyle = ['width' => 0.1];
    public $headerWidth = 175;
    private $_doubleLineConfig = [1, -4];

    public function doubleLine($adjust = null)
    {
        [ $line1Adjust, $line2Adjust ] = $adjust ?? $this->_doubleLineConfig;

        $this->drawHeader(1, $line1Adjust, $this->lineStyle, false);
        $this->drawHeader(1, $line2Adjust, $this->lineStyle, true);
    }

    public function rowDetail($row)
    {
        $this->Cell(40, 0, $row['col-1'], 0, 0, 'L', 0, '', 0);
        $this->Cell(40, 0, $row['col-2'], 0, 0, 'R', 0, '', 0);
        $this->Cell(40, 0, $row['col-3'], 0, 0, 'R', 0, '', 0);
        $this->Cell(20, 0, $row['col-4'], 0, 0, 'R', 0, '', 0);
        $this->Cell(20, 0, $row['col-5'], 0, 0, 'R', 0, '', 0);
        $this->Cell(15, 0, $row['col-6'], 0, 1, 'R', 0, '', 0);
    }

    public function headerDetail($key, $value, $cellWidth = 70)
    {
        $this->Cell($cellWidth, 0, $key . ': ', 0, 0, 'R', 0, '', 0);
        $this->Cell(40, 0, $value, 0, 1, 'L', 0, '', 0);
    }

    public function drawHeader($xAdjust, $yAdjust, $style, $writeLn = false)
    {
        if ($writeLn) {
            $this->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
        }

        [$x, $y] = [$this->GetX(), $this->getY()];

        $this->Line($x + $xAdjust, $y + $yAdjust, $x + $this->headerWidth, $y + $yAdjust, $style);
    }

    public function HeaderImage()
    {
        // Logo
        $image_file = WWW_ROOT . 'img/' . Configure::read('PdfPickList.img');

        $image = mime_content_type($image_file);

        switch ($image) {
              case 'image/jpeg':
                  $imageType = 'JPG';
                  break;
              case 'image/png':
                  $imageType = 'PNG';
                  break;
              case 'image/svg+xml':
                  $imageType = 'SVG';
                break;
              default:
                  throw new NotFoundException('Footer image type unknown');
          }

        if ($imageType === 'SVG') {
            $this->ImageSVG($image_file, $x = 16, $y = 10, $w = '', $h = 9, $link = '', $align = '', $palign = '', $border = 0, $fitonpage = false);
            $this->setXY(76, 19);
        } else {
            $this->Image(
                $image_file,
                16,
                10,
                60,
                '',
                $imageType,
                '',
                'B',
                false,
                300,
                '',
                false,
                false,
                0,
                false,
                false,
                false
            );
        }
    }

    // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps,CakePHP.WhiteSpace.FunctionSpacing.Concrete -- Header
    public function Header()
    {
        $this->HeaderImage();
        // Set font
        $this->SetFont('dejavusans', 'B', 13);
        // Title
        // Cell( $w, $h = 0, $txt = '',
        // $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M' )
        $this->Cell(55, 15, 'Pick List', 0, false, 'C', 0, '', 0, false, 'M', 'T');

        $this->drawHeader(1, -1, $this->lineStyle, true);
    }

    // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps,CakePHP.WhiteSpace.FunctionSpacing.Concrete -- Header
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('dejavusans', 'I', 8);
        // Page number
        $this->Cell(
            0,
            10,
            'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(),
            0,
            1,
            'C',
            0,
            '',
            0,
            false
        );

        $this->Cell(
            0,
            0,
            sprintf('%s %s', "\u{00A9}", Configure::read('companyName')),
            0,
            false,
            'L',
            0,
            '',
            0,
            false,
            'T',
            'M'
        );
    }
}
