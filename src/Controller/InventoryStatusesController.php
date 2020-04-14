<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InventoryStatuses Controller
 *
 * @property \App\Model\Table\InventoryStatusesTable $InventoryStatuses
 *
 * @method \App\Model\Entity\InventoryStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InventoryStatusesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $inventoryStatuses = $this->paginate($this->InventoryStatuses);

        $this->set('stockViewPerms', $this->InventoryStatuses->createStockViewPermsList());

        $this->set(compact('inventoryStatuses'));
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Status id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryStatus = $this->InventoryStatuses->get($id, [
            'contain' => ['Pallets', 'ProductTypes'],
        ]);

        $this->set('stockViewPerms', $this->InventoryStatuses->createStockViewPermsList());

        $this->set('inventoryStatus', $inventoryStatus);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryStatus = $this->InventoryStatuses->newEmptyEntity();
        if ($this->request->is('post')) {
            $inventoryStatus = $this->InventoryStatuses->patchEntity($inventoryStatus, $this->request->getData());
            if ($this->InventoryStatuses->save($inventoryStatus)) {
                $this->Flash->success(__('The inventory status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inventory status could not be saved. Please, try again.'));
        }
        $this->set('stockViewPerms', $this->InventoryStatuses->createStockViewPermsList());
        $this->set(compact('inventoryStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Status id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryStatus = $this->InventoryStatuses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryStatus = $this->InventoryStatuses->patchEntity($inventoryStatus, $this->request->getData());
            $inventoryStatus->perms = $this->request->getData('perms');
            if ($this->InventoryStatuses->save($inventoryStatus)) {
                $this->Flash->success(__('The inventory status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inventory status could not be saved. Please, try again.'));
        }
        $this->set('stockViewPerms', $this->InventoryStatuses->createStockViewPermsList());
        $this->set(compact('inventoryStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Status id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryStatus = $this->InventoryStatuses->get($id);
        if ($this->InventoryStatuses->delete($inventoryStatus)) {
            $this->Flash->success(__('The inventory status has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}