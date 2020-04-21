<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * ProductTypes Controller
 *
 * @property \App\Model\Table\ProductTypesTable $ProductTypes
 *
 * @method \App\Model\Entity\ProductType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductTypesController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['InventoryStatuses', 'PutawayLocation'],
        ];
        $productTypes = $this->paginate($this->ProductTypes);

        $this->set(compact('productTypes'));
    }

    /**
     * View method
     *
     * @param  string|null                                        $id Product Type id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productType = $this->ProductTypes->get($id, [
            'contain' => [
                'InventoryStatuses',
                'Locations',
                'Items',
                'Pallets',
                'ProductionLines',
                'Shifts',
                'Shipments',
                'PutawayLocation',
            ],
        ]);

        $this->set('productType', $productType);
        $this->set('_serialize', ['productType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productType = $this->ProductTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $productType = $this->ProductTypes->patchEntity($productType, $this->request->getData());
            if ($this->ProductTypes->save($productType)) {
                $this->Flash->success(__('The product type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product type could not be saved. Please, try again.'));
        }
        $locations = $this->ProductTypes->Locations->find('list')->where(['is_hidden' => 0]);

        $inventoryStatuses = $this->ProductTypes->InventoryStatuses->find('list', ['limit' => 200]);
        $this->set(compact('productType', 'inventoryStatuses', 'locations'));
    }

    /**
     * Edit method
     *
     * @param  string|null                                        $id Product Type id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productType = $this->ProductTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productType = $this->ProductTypes->patchEntity($productType, $this->request->getData());
            if ($this->ProductTypes->save($productType)) {
                $this->Flash->success(__('The product type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product type could not be saved. Please, try again.'));
        }
        $inventoryStatuses = $this->ProductTypes->InventoryStatuses->find('list', ['limit' => 200]);

        $locations = $this->ProductTypes->Locations->find('list')->where(['is_hidden' => 0]);

        $this->set(compact('productType', 'inventoryStatuses', 'locations'));
    }

    /**
     * Delete method
     *
     * @param  string|null                                        $id Product Type id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productType = $this->ProductTypes->get($id);
        if ($this->ProductTypes->delete($productType)) {
            $this->Flash->success(__('The product type has been deleted.'));
        } else {
            $this->Flash->error(__('The product type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}