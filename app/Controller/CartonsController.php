<?php
App::uses('AppController', 'Controller');
/**
 * Cartons Controller
 *
 * @property Carton $Carton
 * @property PaginatorComponent $Paginator
 */
class CartonsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator'];

    /**
     * BeforeFilter
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.
        //$this->Auth->allow('palletReferenceLookup');
        $this->Auth->deny();
    }

    /**
     * @param array $user User  object
     *
     * @return mixed|bool
     */
    public function isAuthorized($user)
    {
        $roles_actions = Configure::read('LabelsRolesActions');

        foreach ($roles_actions as $ra) {
            // The owner of a post can edit and delete it
            if (in_array($this->request->action, $ra['actions']) && in_array($user['role'], $ra['roles'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    /**
     * editPalletCartons
     * @param palletID $palletId id of pallet
     * @return mixed
     */
    public function editPalletCartons($palletId = null)
    {
        if (!$this->Carton->Pallet->exists($palletId)) {
            throw new NotFoundException('Pallet Id incorrect or missing');
        }
        $palletCartons = $this->Carton->Pallet->find(
            'first',
            [
                'conditions' => [
                    'Pallet.id' => $palletId,
                ],
            ]
        );

        if (isset($palletCartons['Shipment']['shipped']) && (bool)$palletCartons['Shipment']['shipped']) {
            $this->Flash->error('Cannot edit cartons on a pallet that is already shipped');

            return $this->redirect($this->referer());
        }

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->data['Carton'];

            $update = array_filter($data, function ($item) {
                return $item['count'] > 0 && $item['production_date'];
            });

            $delete = array_filter($data, function ($item) {
                return $item['count'] == 0 && $item['id'] > 0;
            });

            $total = array_sum(Hash::extract($update, '{n}.count'));
            $this->Carton->Pallet->save(
                [
                    'id' => $palletId,
                    'qty' => $total,
                    'qty_user_id' => $this->request->data['Pallet']['qty_user_id'],
                ]
            );

            $deleteIds = Hash::extract($delete, '{n}.id');

            $deleteOK = false;
            $updateOK = false;
            if ($deleteIds) {
                if (
                    $this->Carton->deleteAll(
                        [
                            'Carton.id IN' => $deleteIds,
                        ],
                        false
                    )
                ) {
                    $deleteOK = true;
                } else {
                    $this->Flash->error('Delete Error');
                };
            }

            if ($update) {
                if ($this->Carton->saveAll($update)) {
                    $updateOK = true;
                } else {
                    $validationErrors = $this->Carton->validationErrors;
                    $errorText = $this->Carton->formatValidationErrors($validationErrors);
                    if ($errorText) {
                        $msg = __('<strong>Update Error: </strong> %s', $errorText);
                    } else {
                        $msg = '<strong>Update Error</strong>';
                    }

                    $this->Flash->error($msg);
                };
            }

            if (($update && $updateOK) || ($deleteIds && $deleteOK)) {
                return $this->redirect(
                    [
                        'controller' => 'Pallets',
                        'action' => 'view',
                        $palletId,
                    ]
                );
            }
        }
        $cartons = $palletCartons['Carton'];
        array_push($cartons, [
            'count' => '',
            'best_before' => '',
            'pallet_id' => $palletId,
        ]);

        $palletCartons['Carton'] = $cartons;

        if ($this->Auth->User('id')) {
            $palletCartons['Pallet']['qty_user_id'] = $this->Auth->User('id');
        }

        $this->request->data = $palletCartons;

        $this->set(compact('palletCartons'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Carton->recursive = 0;
        $this->set('cartons', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param int $id ID of Carton
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Carton->exists($id)) {
            throw new NotFoundException(__('Invalid carton'));
        }
        $options = ['conditions' => ['Carton.' . $this->Carton->primaryKey => $id]];
        $this->set('carton', $this->Carton->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Carton->create();
            if ($this->Carton->save($this->request->data)) {
                $this->Flash->success(__('The carton has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The carton could not be saved. Please, try again.'));
            }
        }
        $pallets = $this->Carton->Pallet->find('list');
        $this->set(compact('pallets'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id ID of Carton
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->Carton->exists($id)) {
            throw new NotFoundException(__('Invalid carton'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Carton->save($this->request->data)) {
                $this->Flash->success(__('The carton has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The carton could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Carton.' . $this->Carton->primaryKey => $id]];
            $this->request->data = $this->Carton->find('first', $options);
        }
        $pallets = $this->Carton->Pallet->find('list');
        $this->set(compact('pallets'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id ID of Carton
     * @return mixed
     */
    public function delete($id = null)
    {
        if (!$this->Carton->exists($id)) {
            throw new NotFoundException(__('Invalid carton'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Carton->delete($id)) {
            $this->Flash->success(__('The carton has been deleted.'));
        } else {
            $this->Flash->error(__('The carton could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}