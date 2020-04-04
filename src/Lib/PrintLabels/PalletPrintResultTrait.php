<?php

namespace App\Lib\PrintLabels;

trait PalletPrintResultTrait
{
    protected function handleResult(
        $printResult,
        $printerDetails,
        $palletRef,
        $palletData,
        $modelName,
        $debug,
        $createRecord = true
    ) {
        if ($debug || $printResult['return_value'] === 0) {
            if ($createRecord) {
                $palletRecord = $this->Pallets->newEntity($palletData);
                $result = $this->Pallets->save($palletRecord);
            }

            $msg = $this->Pallets->createSuccessMessage(
                $palletRef,
                $printResult,
                $printerDetails['name'] . ' ',
                $debug
            );

            $func = $msg['type'];

            $this->Flash->$func($msg['msg'], ['escape' => false]);

            return $this->redirect($this->request->getData()['refer']);
        } else {
            $this->Flash->error(
                __(
                    '<strong>Error: </strong> %s <strong>Command: </strong> %s',
                    h($printResult['stderr']),
                    h($printResult['cmd'])
                )
            );
        }
    }
}