<?php

/**
 * trait ResultTrait
 * This handles the return value from the print process and
 * then displays the correct success|error message based
 * on success it saves the data to the print_log table
 */
trait ResultTrait
{
    private function handlePrintResult(
        array $printResult,
        array $printerDetails,
        array $printTemplate,
        array $saveData
    ) {
        if ($printResult['return_value'] === 0) {
            $this->PrintLabel->save($saveData);

            $message = __(
                'Sent %s to printer %s',
                $printTemplate['PrintTemplate']['name'],
                $printerDetails['Printer']['name']
            );

            $this->Flash->success($message);

            return $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
        } else {
            $message = __(
                'Failed sending %s to printer %s - %s',
                $printTemplate['PrintTemplate']['name'],
                $printerDetails['Printer']['name'],
                $printResult['stderr']
            );
            $this->Flash->error($message);
        }
    }
}