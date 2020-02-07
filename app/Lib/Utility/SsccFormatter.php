<?php

class SsccFormatter
{
    public $sscc = null;

    public function __construct($sscc)
    {
        $this->format($sscc);
    }

    /**
     * Format an SSCC to have a space
     * 093115790028451382
     * 0 9311579 002845138 2
     * @param string $sscc SSCC
     */
    protected function format($sscc)
    {
        if (!is_numeric($sscc) || strlen($sscc) !== 18) {
            $this->sscc = null;

            return;
        }

        $this->sscc = sprintf(
            '%s %7s %9s %1s',
            substr($sscc, 0, 1),
            substr($sscc, 1, 7),
            substr($sscc, 8, 9),
            substr($sscc, -1)
        );
    }
}
