<?php

declare(strict_types=1);

namespace App\Lib\Utility;


class Barcode
{
    public $sscc = null;

    public $companyPrefixLength = 0;

    public $companyPrefix = '';
    public $serialNumber = '';
    public $extensionDigit = 0;
    public $checkDigit = null;

    public function __construct($extensionDigit = null, $companyPrefix = null, $serialNumber = null)
    {
        if ($companyPrefix) {
            $this->companyPrefix = $companyPrefix;
            $this->$serialNumber = $serialNumber;
            $this->extensionDigit = $extensionDigit;
            $this->sscc = $this->generateSSCC($extensionDigit, $companyPrefix, $serialNumber);
        }
    }


    public function getSscc(){
        return $this->sscc;
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
            $barcodeLength = strlen($barcode);
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

    /**
     * Generate an SSCC number with check digit
     *
     * @return string
     *                phpcs:disable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
     */
    public function generateSSCCWithCheckDigit($sscc)
    {
        return $sscc . $this->generateCheckDigit($sscc);
    }

    /**
     * @return mixed
     */
    public function generateSSCC($extensionDigit, $companyPrefix, $serialNumber)
    {

        $companyPrefixLength = strlen($companyPrefix);

        $fmt = '%0' . (16 - $companyPrefixLength) . 'd';

        $serialNumber = sprintf($fmt, $serialNumber);

        $sscc = sprintf('%s%s%s', $extensionDigit, $companyPrefix, $serialNumber);

        return $this->generateSSCCWithCheckDigit($sscc);
    }



    //phpcs:enable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps

    /**
     * when fed a barcode number returns the GS1 checkdigit number
     *
     * @param  string $number barcode number
     * @return string barcode number
     */
    public function generateCheckDigit($number)
    {
        $sum = 0;
        $index = 0;
        $cd = 0;
        for ($i = strlen($number); $i > 0; $i--) {
            $digit = substr($number, $i - 1, 1);
            $index++;

            $ret = $index % 2;
            if ($ret == 0) {
                $sum += $digit * 1;
            } else {
                $sum += $digit * 3;
            }
        }
        $mod_sum = $sum % 10;
        // if it exactly divide the checksum is 0
        if ($mod_sum == 0) {
            $cd = 0;
        } else {
            // go to the next multiple of 10 above and subtract
            $cd = 10 - $mod_sum + $sum - $sum;
        }

        return $cd;
    }
}
