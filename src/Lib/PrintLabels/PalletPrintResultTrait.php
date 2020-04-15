<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels;

use Cake\Core\Exception\Exception;
use Cake\Core\InstanceConfigTrait;
use Cake\View\StringTemplateTrait;
use RuntimeException;

trait PalletPrintResultTrait
{
    use StringTemplateTrait;
    use InstanceConfigTrait;

    private $_defaultConfig = [
        'templates' => [
            'createMessage' => 'Pallet labels for <strong>{{codeDesc}}</strong> with reference' .
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
    public function createSuccessMessage($pallet_ref, $return_value, $palletRecord, $printerDetails, $debugMode = false)
    {
        $message = $this->formatTemplate('createMessage', [
            'codeDesc' => $palletRecord->code_desc,
            'reference' => $pallet_ref,
            'printer' => $printerDetails['name'],
        ]);

        $alertType = 'success';
        $debugText = '';

        if ($return_value['return_value'] !== 0) {
            $alertType = 'error';
            $debugText = $return_value['stderr'];
        }

        if ($debugMode) {
            $message = $this->formatTemplate('debug', [
                'message' => $message,
                'debug' => $debugText,
            ]);
        }

        return [
            'type' => $alertType,
            'message' => $message,
        ];
    }

    /*
         $printResult,
                    $printerDetails,
                    $pallet_ref,
                    $palletData,
                    $isPrintDebugMode,
                    $data['refer']
    */

    /**
     *
     * @param  array                          $printResult    Array containing cmd, stdout, stderr, return value
     * @param  mixed                          $printerDetails
     * @param  mixed                          $palletRef
     * @param  \App\Model\Entity\Pallet|array $palletData     entity or array of data to save
     * @param  bool                           $debug          are we in print debugmode which causes a record to be saved even if print result is not 0
     * @param  mixed                          $referer
     * @param  bool                           $createRecord
     * @return mixed|void
     * @throws RuntimeException
     * @throws Exception
     */
    protected function handleResult(
        array $printResult,
        \App\Model\Entity\Printer $printerDetails,
        string $palletRef,
        $palletData,
        bool $debug,
        string $referer,
        bool $createRecord = true
    ) {
        if ($debug || $printResult['return_value'] === 0) {
            if ($createRecord) {
                $palletRecord = $this->Pallets->newEntity($palletData);
                $result = $this->Pallets->save($palletRecord);
            } else {
                $palletRecord = $palletData;
            }

            $msg = $this->createSuccessMessage(
                $palletRef,
                $printResult,
                $palletRecord,
                $printerDetails,
                $debug
            );

            $func = $msg['type'];

            $this->Flash->$func($msg['message'], ['escape' => false]);

            return $this->redirect($referer);
        } else {
            $this->Flash->error(
                __(
                    '<strong>Error: </strong> {0} <strong>Command: </strong> {0}',
                    h($printResult['stderr']),
                    h($printResult['cmd'])
                )
            );
        }
    }
}