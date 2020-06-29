<?php

declare(strict_types=1);

namespace App\Lib\PrintLabels;
use Cake\Core\InstanceConfigTrait;
use Cake\View\StringTemplateTrait;

trait PalletPrintResultTrait
{
    use StringTemplateTrait, InstanceConfigTrait;

    private $_defaultConfig = [
        'templates' => [
            'message' => 'Pallet labels for <strong>{{codeDesc}}</strong> with reference' .
                ' <strong>{{reference}}</strong> have been sent to <strong>{{printer}}</strong>',
            'debug' => '<strong>IN DEBUG MODE: </strong> {{debug}} {{message}}',
        ],
    ];

    /**
     *
     * @param string $pallet_ref     Pallet reference e.g. B1234567, 00123456
     * @param array  $return_value   The array containing the return value of the process
     * @param array  $printerDetails Print friendly name e.g "PDF Printer" or "CAB Bottling"
     * @param bool   $debugMode      True if the CAKEPHP_DEBUG value is > 0
     *
     * @return array An array of strings
     */
    public function createMessage(
        $pallet,
        $printer
    ) {
        $message = $this->formatTemplate('message', [
            'codeDesc' => $pallet->code_desc,
            'reference' => $pallet->pl_ref,
            'printer' => $printer->name,
        ]);

        return $message;
    }
}
