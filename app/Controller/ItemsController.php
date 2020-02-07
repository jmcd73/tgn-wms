<?php

App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
App::uses('Folder', 'Utility');

/**
 * Items Controller
 *
 * @property Item $Item
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ItemsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator', 'Session'];

    /**
     * Before filter
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Item->recursive = 0;

        $this->Paginator->settings = [
            'Item' => [
                'order' => [
                    'code' => 'ASC',
                ],
            ],
        ];

        $item_list = $this->Item->find('list', [
            'order' => [
                'Item.code' => 'ASC',
            ],
        ]);

        $this->set('items', $this->Paginator->paginate());
        $this->set(compact('item_list'));
        $this->set('_serialize', ['items']);
    }

    /**
     * @param int $id Product ID
     * @return void
     */
    public function product($id = null)
    {
        $this->layout = 'ajax';

        if (!$this->Item->exists($id)) {
            throw new NotFoundException(__('Invalid item'));
        }

        $options = ['conditions' => ['Item.' . $this->Item->primaryKey => $id]];
        $this->set('product', $this->Item->find('first', $options));
    }

    /**
     * @param int $productTypeId Product Type ID
     * @return void
     */
    public function partList($productTypeId = null)
    {
        $this->Item->recursive = -1; // don't get related data only item

        //$this->layout = 'xml/default';

        $options = [
            'conditions' => [
                'active' => 0,
            ],
        ];
        if ($productTypeId) {
            $options['conditions']['product_type_id'] = $productTypeId;
        }

        $this->autoRender = false;

        $items = $this->Item->find('all', $options);

        $xml = new SimpleXMLElement('<productList/>');
        $xml->addAttribute('madeBy', 'Toggen');
        foreach ($items as $item) {
            $itemNode = $xml->addChild('item');
            $itemNode->addChild('code', $item['Item']['code']);
            $itemNode->addChild('desc', h(strtoupper($item['Item']['description'])));
            $itemNode->addChild('plQty', $item['Item']['quantity']);
            $itemNode->addChild('active', 'yes');
            $itemNode->addChild('gtinEa', $item['Item']['trade_unit']);
            $itemNode->addChild('gtinCu', $item['Item']['consumer_unit']);
        }

        $this->response->type('text/xml');
        $this->response->body($xml->asXML());
    }

    /**
     * @param int $code item code
     * @return void
     */
    public function productListByCode($code = null)
    {
        $search_term = $this->request->query['term'];

        $this->Item->recursive = -1; // don't get related data only item
        $this->layout = 'ajax';
        $options = [
            'conditions' => [
                'code LIKE' => '%' . $search_term . '%',
            ],
            'order' => [
                'code' => 'ASC',
            ],
        ];
        $json_output = $this->Item->find('all', $options);

        $this->layout = 'ajax';
        // $this->autoRender = false;
        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    /**
     * @param int $productTypeId ID of product Type
     * @return void
     */
    public function productList($productTypeId = null)
    {
        $this->Item->recursive = -1; // don't get related data only item
        $this->layout = 'ajax';
        $options = [
            'conditions' => [
                'active' => 1,
                'product_type_id' => $productTypeId,
            ],
            'order' => [
                'code' => 'ASC',
            ],
        ];
        $items = $this->Item->find('all', $options);
        // allow cross domain request CORS Cross-origin resource sharing

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id ID of Item
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Item->exists($id)) {
            throw new NotFoundException(__('Invalid item'));
        }
        $options = ['conditions' => ['Item.' . $this->Item->primaryKey => $id]];
        $this->set('item', $this->Item->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Item->create();
            if ($this->Item->save($this->request->data)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }

        $printTemplates = $this->Item->PrintTemplate->generateTreeList(
            [
                'PrintTemplate.active' => true,
            ],
            null,
            null,
            '&nbsp;&nbsp;&nbsp;&nbsp;'
        );

        $productTypes = $this->Item->ProductType->find('list');

        $packSizes = $this->Item->PackSize->find('list');
        $global_min_days_life = $this->getSetting('min_days_life');
        $defaultPalletLabelCopies = $this->getSetting('sscc_default_label_copies');
        $this->set(
            compact(
                'packSizes',
                'defaultPalletLabelCopies',
                'printTemplates',
                'global_min_days_life',
                'productTypes'
            )
        );
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id ID of Item
     * @return mixed
     */
    public function edit($id = null)
    {
        $item_id = $this->request->query('item_id');

        if ($this->Item->exists($id)) {
            // ok continue
        } elseif ($this->Item->exists($item_id)) {
            $id = $item_id;
        } else {
            $this->Flash->error(__('Invalid item'));
            $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            if ($this->Item->save($this->request->data)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        } else {
            $options = [
                'recursive' => -1,
                'conditions' => ['Item.' . $this->Item->primaryKey => $id], ];
            $this->request->data = $this->Item->find('first', $options);
        }

        $printTemplates = $this->Item->PrintTemplate->generateTreeList(
            [
                'PrintTemplate.active' => true,
            ],
            null,
            null,
            '&nbsp;&nbsp;&nbsp;&nbsp;'
        );
        $global_min_days_life = $this->getSetting('min_days_life');
        $packSizes = $this->Item->PackSize->find('list', [
            'recursive' => -1,
        ]);
        $productTypes = $this->Item->ProductType->find('list', [
            'recursive' => -1,
        ]);
        $defaultPalletLabelCopies = $this->getSetting('sscc_default_label_copies');
        $this->set(
            compact(
                'packSizes',
                'defaultPalletLabelCopies',
                'printTemplates',
                'global_min_days_life',
                'productTypes'
            )
        );
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id Item ID to delete
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->Item->id = $id;
        if (!$this->Item->exists()) {
            throw new NotFoundException(__('Invalid item'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Item->delete()) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}