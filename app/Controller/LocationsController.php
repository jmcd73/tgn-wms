<?php
App::uses('AppController', 'Controller');
/**
 * Locations Controller
 *
 * @property Location $Location
 * @property PaginatorComponent $Paginator
 */
class LocationsController extends AppController
{

/**
 * Components
 *
 * @var array
 */
    public $components = ['Paginator'];

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
        $this->Location->Behaviors->load('Containable');
        $this->Location->recursive = -1;

        $location_list = $this->Location->find(
            'list', [
                'order' => [
                    'location' => 'ASC'
                ]

            ]
        );
        $this->Paginator->settings = [
            'contain' => [
                'ProductType'
            ]
        ];

        $this->set('locations', $this->Paginator->paginate());
        $this->set(compact('location_list'));
        $this->set('_serialize', ['location_list']);
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
        if (!$this->Location->exists($id)) {
            throw new NotFoundException(__('Invalid location'));
        }

        $options = [
            'conditions' => [
                'Location.' . $this->Location->primaryKey => $id
            ],
            'contain' => true
        ];

        $labelOptions = [
            'conditions' => [
                'Label.location_id' => $id
            ],
            'contain' => ['Location', 'Shipment'],
            'limit' => 100
        ];
        $this->Paginator->settings = $labelOptions;

        $labels = $this->Paginator->paginate('Label');

        $this->set('labels', $labels);
        $this->set('location', $this->Location->find('first', $options));
    }

/**
 * add method
 *
 * @return void
 */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Location->create();
            if ($this->Location->save($this->request->data)) {
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
            }
        }

        $productTypes = $this->Location->ProductType->find('list');
        $this->set(compact('productTypes'));
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

        if (!empty($this->request->query['id'])) {
            $id = $this->request->query('id');
        }

        if (!$id) {
            $this->Flash->error('Please select a location to edit');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            if ($this->Location->save($this->request->data)) {
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
            }
        } else {
            $options = [
                'recursive' => -1,
                'conditions' => ['Location.' . $this->Location->primaryKey => $id]];
            $this->request->data = $this->Location->find('first', $options);
        }

        $productTypes = $this->Location->ProductType->find('list');
        $this->set(compact('productTypes'));

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
        $this->Location->id = $id;
        if (!$this->Location->exists()) {
            throw new NotFoundException(__('Invalid location'));
        }
        $this->request->allowMethod('post', 'delete');
        // don't cascade delete the labels too
        if ($this->Location->delete($id, false)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
