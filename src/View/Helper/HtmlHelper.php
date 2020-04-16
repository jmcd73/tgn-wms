<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Lib\Utility\Barcode;
use Cake\ORM\TableRegistry;
use Cake\View\View;

class HtmlHelper extends \BootstrapUI\View\Helper\HtmlHelper
{
    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);
    }

    public function printTemplateType($printTemplate)
    {
        $textTemplate = $printTemplate['PrintTemplate']['text_template'];
        $glabelsTemplate = $printTemplate['PrintTemplate']['file_template'];

        if (empty($textTemplate) && !empty($glabelsTemplate)) {
            return 'file-pdf';
        }

        if (empty($glabelsTemplate) && !empty($textTemplate)) {
            return 'file-code';
        }

        return false;
    }

    /**
     * Format a SSCC string and return it
     *
     * @param  string $sscc SSCC String
     * @return mixed
     */
    public function sscc($sscc)
    {
        $companyPrefix = TableRegistry::get('Settings')->getCompanyPrefix();

        return (new Barcode())->ssccFormat($sscc, $companyPrefix);
    }

    /**
     * buildClass takes an array or string of classes and returns
     * class="class1 class2 class4"
     * @param  mixed  $classes array or string
     * @return string
     */
    public function buildClass($classes)
    {
        if (!is_array($classes)) {
            $classes = [$classes];
        }

        return 'class="' . trim(implode(' ', $classes)) . '"';
    }
}