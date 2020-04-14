<?php
declare(strict_types=1);

namespace App\Controller;

use App\Lib\PrintLabels\PrinterListTrait;
use Cake\Core\Configure;

/**
 * Printers Controller
 *
 * @property \App\Model\Table\PrintersTable $Printers
 *
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PrintersController extends AppController
{
    use PrinterListTrait;

    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $printers = $this->paginate($this->Printers);

        $this->set(compact('printers'));
    }

    /**
     * View method
     *
     * @param string|null $id Printer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $printer = $this->Printers->get($id, [
            'contain' => ['Pallets', 'ProductionLines'],
        ]);

        $this->set('printer', $printer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $printer = $this->Printers->newEmptyEntity();
        if ($this->request->is('post')) {
            $printer = $this->Printers->patchEntity($printer, $this->request->getData());
            if ($this->Printers->save($printer)) {
                $this->Flash->success(__('The printer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The printer could not be saved. Please, try again.'));
        }

        $a = $this->Ctrl->getPrintActions();

        $setAsDefaultOnTheseActions = array_combine($a, $a);

        $queueNames = $this->getLocalPrinterList();

        $this->set(compact('printer', 'queueNames', 'setAsDefaultOnTheseActions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Printer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $printer = $this->Printers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $data['set_as_default_on_these_actions'] = implode("\n", $data['set_as_default_on_these_actions']);

            $printer = $this->Printers->patchEntity($printer, $data);
            if ($this->Printers->save($printer)) {
                $this->Flash->success(__('The printer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The printer could not be saved. Please, try again.'));
        }

        $a = $this->Ctrl->getPrintActions();

        $setAsDefaultOnTheseActions = array_combine($a, $a);

        $queueNames = $this->getLocalPrinterList();

        $this->set(compact('printer', 'setAsDefaultOnTheseActions', 'queueNames'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Printer id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $printer = $this->Printers->get($id);
        if ($this->Printers->delete($printer)) {
            $this->Flash->success(__('The printer has been deleted.'));
        } else {
            $this->Flash->error(__('The printer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}