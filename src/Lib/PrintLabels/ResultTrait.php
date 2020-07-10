<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels;

use App\Model\Entity\PrintTemplate;
use Cake\Core\InstanceConfigTrait;
use Cake\View\StringTemplateTrait;
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
        array $saveData,
        $config = []
    ) {
        if ($printResult['return_value'] === 0) {
           
            $event = new Event('Model.PrintLog.savePrintRecord', $saveData);
            $this->{$this->modelClass}->getEventManager()->dispatch($event);

            $message = __(
                $config['success']['template'],
                $config['success']['values']
            );

            $this->Flash->success($message, ['escape' => false]);

            $redirectTo = ! empty($config['referer']) ? $config['referer'] : ['action' => 'completed'];

            return $this->redirect($redirectTo);
            
        } else {
           
            $message = __(
                $config['error']['template'],
                $config['error']['values']
            );

            $this->Flash->error($message, ['escape' => false]);
            $controller = $this->request->getParam('controller');
            $action = $this->request->getParam('action');
            return $this->redirect(['controller' => $controller, 'action' => $action]);
        }
    }
}