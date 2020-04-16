<?php
declare(strict_types=1);

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
            $newEntity = $this->PrintLog->newEntity($saveData);
            $savedEntity = $this->PrintLog->save($newEntity);

            $message = __(
                'Sent <strong>{0}</strong> to printer <strong>{1}</strong> {2} :-: {3}',
                $printTemplate['name'],
                $printerDetails['name'],
                $printResult['stdout'],
                $printResult['stderr'],
            );

            $this->Flash->success($message, ['escape' => false]);

            return $this->redirect(['action' => 'completed', $savedEntity->id]);
        } else {
            $message = __(
                'Failed sending <strong>{0}</strong> to printer <strong>{1}</strong> - <strong>{2}</strong>',
                $printTemplate['name'],
                $printerDetails['name'],
                $printResult['stderr']
            );
            $this->Flash->error($message, ['escape' => false]);
            $controller = $this->request->getParam('controller');
            $action = $this->request->getParam('action');
            return $this->redirect(['controller' => $controller, 'action' => $action]);
        }
    }
}