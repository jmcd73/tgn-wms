<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\CabLabel;

use Cake\Core\Exception\Exception;

class CabLabel
{
    /**
     * Company Name Header
     * @var string
     */
    protected $companyName = 'Toggen';

    /**
     * Old QAD Product Codes uniquely identify Oil 6xxxx and Marg 5xxxx products
     * @var string
     */
    protected $internalProductCode = ''; // 5xxxx or 6xxxx

    /**
     * Product reference 8 digits
     * B1234567 for Bottling products
     * 12345678 for Marg Products
     * @var string
     */
    protected $reference = '';

    /**
     * Serial Shipper Container Code
     * 18 Digit SSCC
     * @var string
     */
    protected $sscc = '';

    /**
     * Product Description on label
     * @var string
     */
    protected $description;

    /**
     * GTIN 14 or carton barcode
     * @var string
     */
    protected $gtin14 = '';
    /**
     * Pallet Quantity
     * @var int
     */
    protected $quantity = 0;

    /**
     * Best before date human readable
     * dd/mm/yy
     * @var date
     */
    protected $bestBeforeHr = '';

    /**
     * Best before date barcode
     * yymmdd
     * @var date
     */
    protected $bestBeforeBc = '';

    /**
     * batch number
     * YDDDBB (Year ordinal day batch )
     * 903199 = 2019 Jan 31 Batch 99
     * @var int
     */
    protected $batch = '';

    /**
     * Number of Copies of label to print
     * @var int
     */
    protected $numLabels = 0;

    /**
     * hold format *TOKEN* => value array
     * @var array
     */
    protected $findAndReplaceArray = [];

    /**
     * printContent
     * @var string
     */
    public $printContent = '';
    /**
     * Template
     * @var string
     */
    public $template = '';

    /**
     * Token map
     * Tokens in template mapping to class properties
     *
     */
    public $tokenMap = [];

    /**
     * @param array $labelValues Array of values
     * @param string $template Text Template
     * @param object $replaceTokens Replace tokens
     */
    public function __construct(
        array $labelValues,
        string $template,
        object $replaceTokens
    ) {
        /**
         * set class properties
         */
        if ($labelValues) {
            foreach ($labelValues as $key => $value) {
                if (empty($value)) {
                    throw new Exception('Value ' . $key . ' missing. File: ' . __FILE__ . ' Line: ' . __LINE__);
                } else {
                    $this->$key = $value;
                }
            }
        }
        $this->tokenMap = $replaceTokens;
        $this->template = $template;
        $this->printContent = $this->createPrintContent();
    }

    /**
     * create printContent
     */
    public function createPrintContent()
    {
        $this->findAndReplaceArray = $this->formatReplaceArray();

        return $this->applyValuesToTemplate();
    }

    /**
     * Returns an array indexed by replace tokens with the correct values
     * to replace in a template file
     * e.g.
     * *COMPANY_NAME* => "Toggen IT Services"
     */
    public function formatReplaceArray()
    {
        $tokenPropertyMapped = [];
        foreach ($this->tokenMap as $key => $value) {
            $tokenPropertyMapped[$key] = $this->$value;
        }

        return $tokenPropertyMapped;
    }

    public function applyValuesToTemplate()
    {
        // do the find and replace on the template
        $templateReturn = str_replace(
            array_keys($this->findAndReplaceArray),
            array_values($this->findAndReplaceArray),
            $this->template
        );
        // unixise it and add a \n to the end if needed
        return $this->formatTemplate($templateReturn);
    }

    /**
     * formatTemplate remove dos new lines add trailing newline if missing
     * @param string $template_string The string with the printer commands in it
     * @return string
     */
    private function formatTemplate($template_string)
    {
        // dos2unix
        $template_string_ret = str_replace("\r", '', $template_string);
        // add trailing newline if needed
        if (substr($template_string_ret, -1) !== "\n") {
            $template_string_ret .= "\n";
        }

        return $template_string_ret;
    }
}