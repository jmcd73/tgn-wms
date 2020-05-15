<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels;

use App\Model\Entity\PrintTemplate;
use Cake\ORM\Entity;

/**
 * trait ResultTrait
 * This handles the return value from the print process and
 * then displays the correct success|error message based
 * on success it saves the data to the print_log table
 *
 * @param App\Model\Entity\PrintTemplate $printTemplate Print Template Entity
 */
trait ResultTrait
{
    private function handlePrintResult(
        array $printResult,
        Entity $printerDetails,
        PrintTemplate $printTemplate,
        array $saveData
    ) {
        if ($printResult['return_value'] === 0) {
            $newEntity = $this->PrintLog->newEntity($saveData);
            $savedEntity = $this->PrintLog->save($newEntity);

            $message = __(
                'Sent <strong>{0}</strong> to printer <strong>{1}</strong>',
                $printTemplate->name,
                $printerDetails['name'],
            );

            $this->Flash->success($message, ['escape' => false]);

            return $this->redirect(['action' => 'completed', $savedEntity->id]);
        } else {
            $err = empty($printResult['stderr']) ? $printResult['return_value'] : $printResult['stderr'] ;
            $message = __(
                'Failed sending <strong>{0}</strong> to printer <strong>{1}</strong> - <strong>{2}</strong>',
                $printTemplate['name'],
                $printerDetails['name'],
                $err
            );
            tog($printResult);
            $this->Flash->error($message, ['escape' => false]);
            $controller = $this->request->getParam('controller');
            $action = $this->request->getParam('action');
            return $this->redirect(['controller' => $controller, 'action' => $action]);
        }
    }
}