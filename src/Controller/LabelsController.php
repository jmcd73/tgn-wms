<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Labels Controller
 *
 * @property \App\Model\Table\LabelsTable $Labels
 *
 * @method \App\Model\Entity\Label[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LabelsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductionLines', 'Items', 'Printers', 'Locations', 'Shipments', 'InventoryStatuses', 'ProductTypes'],
        ];
        $labels = $this->paginate($this->Labels);

        $this->set(compact('labels'));
    }

    /**
     * View method
     *
     * @param string|null $id Label id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $label = $this->Labels->get($id, [
            'contain' => ['ProductionLines', 'Items', 'Printers', 'Locations', 'Shipments', 'InventoryStatuses', 'ProductTypes'],
        ]);

        $this->set('label', $label);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $label = $this->Labels->newEmptyEntity();
        if ($this->request->is('post')) {
            $label = $this->Labels->patchEntity($label, $this->request->getData());
            if ($this->Labels->save($label)) {
                $this->Flash->success(__('The label has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The label could not be saved. Please, try again.'));
        }
        $productionLines = $this->Labels->ProductionLines->find('list', ['limit' => 200]);
        $items = $this->Labels->Items->find('list', ['limit' => 200]);
        $printers = $this->Labels->Printers->find('list', ['limit' => 200]);
        $locations = $this->Labels->Locations->find('list', ['limit' => 200]);
        $shipments = $this->Labels->Shipments->find('list', ['limit' => 200]);
        $inventoryStatuses = $this->Labels->InventoryStatuses->find('list', ['limit' => 200]);
        $productTypes = $this->Labels->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('label', 'productionLines', 'items', 'printers', 'locations', 'shipments', 'inventoryStatuses', 'productTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Label id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $label = $this->Labels->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $label = $this->Labels->patchEntity($label, $this->request->getData());
            if ($this->Labels->save($label)) {
                $this->Flash->success(__('The label has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The label could not be saved. Please, try again.'));
        }
        $productionLines = $this->Labels->ProductionLines->find('list', ['limit' => 200]);
        $items = $this->Labels->Items->find('list', ['limit' => 200]);
        $printers = $this->Labels->Printers->find('list', ['limit' => 200]);
        $locations = $this->Labels->Locations->find('list', ['limit' => 200]);
        $shipments = $this->Labels->Shipments->find('list', ['limit' => 200]);
        $inventoryStatuses = $this->Labels->InventoryStatuses->find('list', ['limit' => 200]);
        $productTypes = $this->Labels->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('label', 'productionLines', 'items', 'printers', 'locations', 'shipments', 'inventoryStatuses', 'productTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Label id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $label = $this->Labels->get($id);
        if ($this->Labels->delete($label)) {
            $this->Flash->success(__('The label has been deleted.'));
        } else {
            $this->Flash->error(__('The label could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
