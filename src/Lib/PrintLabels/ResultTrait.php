<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels;

use App\Model\Entity\PrintTemplate;
use Cake\ORM\Entity;
use Cake\Event\Event;

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
        array $saveData,
        $referer = null,
        $pallet = null
    ) {
        if ($printResult['return_value'] === 0) {
           
            $event = new Event('Model.PrintLog.savePrintRecord', $saveData);
            $this->{$this->modelClass}->getEventManager()->dispatch($event);

            $message = __(
                'Sent pallet label <strong>{0}</strong> using <strong>{1}</strong> template to printer <strong>{2}</strong>',
                $pallet->pl_ref,
                $printTemplate->name,
                $printerDetails['name'],
            );

            $this->Flash->success($message, ['escape' => false]);

            $redirectTo = ! empty($referer) ? $referer : ['action' => 'completed'];

            return $this->redirect($redirectTo);
            
        } else {
            $err = empty($printResult['stderr']) ? $printResult['return_value'] : $printResult['stderr'] ;
            $message = __(
                'Failed sending <strong>{0}</strong> to printer <strong>{1}</strong> - <strong>{2}</strong>',
                $printTemplate['name'],
                $printerDetails['name'],
                $err
            );

            $this->Flash->error($message, ['escape' => false]);
            $controller = $this->request->getParam('controller');
            $action = $this->request->getParam('action');
            return $this->redirect(['controller' => $controller, 'action' => $action]);
        }
    }
}