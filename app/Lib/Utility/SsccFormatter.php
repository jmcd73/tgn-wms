<?php

class SsccFormatter
{
    public $sscc = null;

    public $companyPrefixLength = 0;

    public function __construct($sscc, $companyPrefix)
    {
        $this->companyPrefixLength = strlen($companyPrefix);
        $this->sscc = $sscc;

        $this->format();
    }

    /**
     * Format an SSCC to have a space between extension digit company prefix serial number and check digit
     * 093115790028451382 becomes 0 9311579 002845138 2 or 0 93115790 02845138 2 depending on prefix length
     * @return void
     */
    protected function format()
    {
        if (!is_numeric($this->sscc) || strlen($this->sscc) !== 18 || !($this->companyPrefixLength > 0)) {
            $this->sscc = null;

            return;
        }

        $referenceNumberLength = 16 - $this->companyPrefixLength;

        $this->sscc = sprintf(
            '%s %s %s %s',
            substr($this->sscc, 0, 1),
            substr($this->sscc, 1, $this->companyPrefixLength),
            substr($this->sscc, $this->companyPrefixLength + 1, $referenceNumberLength),
            substr($this->sscc, -1)
        );
    }
}