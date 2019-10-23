<?php
App::uses('AppController', 'Controller');
/**
 * ProductTypes Controller
 *
 * @property ProductType $ProductType
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ProductTypesController extends AppController
{

/**
 * Components
 *
 * @var array
 */
    public $components = ['Paginator', 'Session', 'Flash'];

/**
 * index method
 *
 * @return void
 */
    public function index()
    {
        $this->ProductType->recursive = 0;
        $productTypes = $this->Paginator->paginate();
        $this->set(compact('productTypes'));
        $this->set('_serialize', ['productTypes']);
        $locations = $this->ProductType->Location->find('list');
        $this->set(compact('locations'));
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null)
    {
        if (!$this->ProductType->exists($id)) {
            throw new NotFoundException(__('Invalid area or type'));
        }

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }


        $options = ['conditions' => ['ProductType.' . $this->ProductType->primaryKey => $id]];
        $locations = $this->ProductType->DefaultLocation->find('list');
        $this->set(compact('locations'));
        $this->set('productType', $this->ProductType->find('first', $options));
        $this->set('_serialize', [ 'productType']);
    }

/**
 * add method
 *
 * @return void
 */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->ProductType->create();
            if ($this->ProductType->save($this->request->data)) {
                $this->Flash->success(__('The area or type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The area or type could not be saved. Please, try again.'));
            }
        }
        $locations = $this->ProductType->Location->find('list');
        $this->set(compact('locations'));
        $inventoryStatus = $this->ProductType->InventoryStatus->find('list');
        $this->set(compact('inventoryStatus'));

        $storageTemps = $this->ProductType->getStorageTemperatureSelectOptions();
        $this->set(compact('storageTemps'));
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($id = null)
    {
        if (!$this->ProductType->exists($id)) {
            throw new NotFoundException(__('Invalid area or type'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->ProductType->save($this->request->data)) {
                $this->Flash->success(__('The area or type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The area or type could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['ProductType.' . $this->ProductType->primaryKey => $id]];
            $productType = $this->ProductType->find('first', $options);
            $this->request->data = $productType;
            $locations = $this->ProductType->Location->find(
                'list', [
                    'conditions' => [
                        'Location.product_type_id' => $productType['ProductType']['id']
                    ]
                ]
            );

            $this->set(compact('locations'));
            $inventoryStatuses = $this->ProductType->InventoryStatus->find('list');
            $this->set(compact('inventoryStatuses'));


            $storageTemps = $this->ProductType->getStorageTemperatureSelectOptions();
            $this->set(compact('storageTemps'));

        }

    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null)
    {
        $this->ProductType->id = $id;
        if (!$this->ProductType->exists()) {
            throw new NotFoundException(__('Invalid area or type'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->ProductType->delete()) {
            $this->Flash->success(__('The area or type has been deleted.'));
        } else {
            $this->Flash->error(__('The area or type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
