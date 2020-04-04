<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Lib\Utility\SsccFormatter;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Toggen helper
 */
class ToggenHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

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
     * @param string $sscc SSCC String
     * @return mixed
     */
    public function sscc($sscc)
    {
        $companyPrefix = TableRegistry::get('Setting')->getCompanyPrefix();

        return (new SsccFormatter($sscc, $companyPrefix))->sscc;
    }

    /**
    * buildClass takes an array or string of classes and returns
    * class="class1 class2 class4"
    * @param mixed $classes array or string
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