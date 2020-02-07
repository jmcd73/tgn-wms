<?php

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
                $this->Pallet->create();
                $result = $this->Pallet->save($palletData);
            }

            $msg = $this->Pallet->createSuccessMessage(
                $palletRef,
                $printResult,
                $printerDetails['Printer']['name'],
                $debug
            );

            $func = $msg['type'];

            $this->Flash->$func($msg['msg']);

            return $this->redirect($this->request->data[$modelName]['refer']);
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
