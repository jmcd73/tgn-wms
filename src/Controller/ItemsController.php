<?php
declare(strict_types=1);

namespace App\Controller;

use App\Lib\Utility\Batch;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
    /**
     * @param  int  $id Product ID
     * @return void
     */
    public function product($id = null)
    {
        $this->layout = 'ajax';

        $item = $this->Items->get($id);

        $this->set('product', $item);

        $this->viewBuilder()->setOption('serialize', 'product');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PackSizes', 'ProductTypes', 'PrintTemplates', 'CartonTemplates'],
        ];
        $items = $this->paginate($this->Items);

        $itemsList = $this->Items->find('list', [
            'keyField' => 'id',
            'valueField' => 'code_desc',
        ]);

        $this->set(compact('items', 'itemsList'));

        $this->set('_serialize', ['items']);
    }

    /**
     * View method
     *
     * @param  string|null                                        $id Item id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['PackSizes', 'ProductTypes', 'PrintTemplates', 'Cartons',  'Pallets'],
        ]);

        $this->set('item', $item);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEmptyEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $packSizes = $this->Items->PackSizes->find('list', ['limit' => 200]);
        $productTypes = $this->Items->ProductTypes->find('list', ['limit' => 200]);
        $printTemplates = $this->Items->PrintTemplates->find('treeList', [
            'spacer' => '&nbsp;&nbsp;',
            'limit' => 200, ]);
        
        $formatList = (new Batch)->getFormatList();

        $this->set(compact('item', 'packSizes', 'productTypes', 'printTemplates', 'formatList'));
    }


    public function getBatchList($id = null) {
        $batchList = [];

        if($id) {
            $item = $this->Items->get($id);
            $batchFormat = $item->batch_format;
            $batchList = (new Batch)->getBatchNumbers($batchFormat);
        }
        

        $this->set('batchList',  $batchList);
        
        $this->viewBuilder()->setOption('serialize', ['batchList']);

    }

    /**
     * Edit method
     *
     * @param  string|null                                        $id Item id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $packSizes = $this->Items->PackSizes->find('list', ['limit' => 200]);
        $productTypes = $this->Items->ProductTypes->find('list', ['limit' => 200]);
        $printTemplates = $this->Items->PrintTemplates->find('treeList', [
            'spacer' => '&nbsp;&nbsp;',
            'limit' => 200, ]);
        $cartonTemplates = $this->Items->CartonTemplates->find('list');
        $formatList = (new Batch)->getFormatList();

        $this->set(compact('formatList', 'item', 'packSizes', 'productTypes', 'printTemplates', 'cartonTemplates'));
    }

    /**
     * Delete method
     *
     * @param  string|null                                        $id Item id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        try {
            $this->Items->deleteOrFail($item);
            $this->Flash->success(__('The item has been deleted.'));
        } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
            $errors = $this->Items->flattenAndFormatValidationErrors($e->getEntity()->getErrors());

            $this->Flash->error(__('The item could not be deleted. Please, try again. {0}', $errors), ['escape' => false]);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param  int  $code item code
     * @return void
     */
    public function productListByCode($code = null)
    {
        $search_term = $this->request->getQuery('term');

        $options = [
            'conditions' => [
                'code LIKE' => '%' . $search_term . '%',
            ],
            'order' => [
                'code' => 'ASC',
            ],
        ];
        $json_output = $this->Items->find('all', $options);

        // $this->autoRender = false;
        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    public function newItemFromCopy()
    {
        // code...

        $item_id = $this->request->getQuery('item_id');

        $itemToClone = null;

        if ($this->request->is('GET') && $item_id) {
            $itemToClone = $this->Items->get($item_id);
            $item = clone $itemToClone;
            $fields = ['id', 'trade_unit', 'consumer_unit', 'code', 'description'];

            foreach ($fields as $field) {
                unset($item->{$field});
            }
            $item = $item->toArray();
            $item = $this->Items->newEntity($item, ['validate' => false]);
        } else {
            $item = $this->Items->newEmptyEntity();
        }

        if ($this->request->is(['post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }

        $items = $this->Items->find('list', [
            'order' => ['code' => 'ASC'],
            'keyField' => 'id',
            'valueField' => 'code_desc',
        ]);

        $packSizes = $this->Items->PackSizes->find('list', ['limit' => 200]);

        $productTypes = $this->Items->ProductTypes->find('list', ['limit' => 200]);

        $printTemplates = $this->Items->PrintTemplates->find('treeList', [
            'spacer' => '&nbsp;&nbsp;',
            'limit' => 200, ]);

        $this->set(compact('items', 'item', 'packSizes', 'productTypes', 'itemToClone', 'printTemplates', 'item_id'));
    }
}