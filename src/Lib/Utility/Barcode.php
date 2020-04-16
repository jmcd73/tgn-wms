<?php
declare(strict_types=1);

namespace App\Lib\Utility;

class Barcode
{
    public $sscc = null;

    public $companyPrefixLength = 0;

    public function __construct()
    {
    }

    public function isValidBarcode($barcode)
    {
        //checks validity of: GTIN-8, GTIN-12, GTIN-13, GTIN-14, GSIN, SSCC
        //see: http://www.gs1.org/how-calculate-check-digit-manually
        $barcode = (string) $barcode;
        //we accept only digits
        if (!preg_match('/^[0-9]+$/', $barcode)) {
            return false;
        }
        //check valid lengths:
        $l = strlen($barcode);
        if (!in_array($l, [8, 12, 13, 14, 17, 18])) {
            return false;
        }
        //get check digit
        $check = substr($barcode, -1);
        $barcode = substr($barcode, 0, -1);
        $sum_even = $sum_odd = 0;
        $even = true;
        $barcodeLength = strlen($barcode);

        while ($barcodeLength > 0) {
            $digit = substr($barcode, -1);
            if ($even) {
                $sum_even += 3 * $digit;
            } else {
                $sum_odd += $digit;
            }
            $even = !$even;
            $barcode = substr($barcode, 0, -1);
            $barcodeLength($barcode);
        }
        $sum = $sum_even + $sum_odd;
        $sum_rounded_up = ceil($sum / 10) * 10;
        $isValid = $check == $sum_rounded_up - $sum;

        return $isValid;
    }

    /**
     * Format an SSCC to have a space between extension digit company prefix serial number and check digit
     * 093115790028451382 becomes 0 9311579 002845138 2 or 0 93115790 02845138 2 depending on prefix length
     *
     * @param  string $sscc          SSCC Number
     * @param  string $companyPrefix Company Prefix
     * @return string
     */
    public function ssccFormat($sscc, $companyPrefix): string
    {
        if (!$this->isValidBarcode($sscc)) {
            return $sscc . ' is not a valid barcode';
        }

        $this->companyPrefixLength = strlen($companyPrefix);
        $this->sscc = $sscc;

        if (!($this->companyPrefixLength > 0)) {
            return $sscc . ' invalid company prefix cannot format';
        }

        $referenceNumberLength = 16 - $this->companyPrefixLength;

        return sprintf(
            '%s %s %s %s',
            substr($this->sscc, 0, 1),
            substr($this->sscc, 1, $this->companyPrefixLength),
            substr($this->sscc, $this->companyPrefixLength + 1, $referenceNumberLength),
            substr($this->sscc, -1)
        );
    }
}