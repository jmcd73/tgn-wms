<?php

namespace App\Lib\PrintLabels;

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
            $this->PrintLog->save($saveData);

            $message = __(
                'Sent <strong>{0}</strong> to printer <strong>{1}</strong>',
                $printTemplate['name'],
                $printerDetails['name']
            );

            $this->Flash->success($message, ['escape' => false]);

            return $this->redirect(['action' => 'completed', $this->PrintLog->id]);
        } else {
            $message = __(
                'Failed sending <strong>{0}</strong> to printer <strong>{1}</strong> - <strong>{2}</strong>',
                $printTemplate['name'],
                $printerDetails['name'],
                $printResult['stderr']
            );
            $this->Flash->error($message, ['escape' => false]);
        }
    }
}