<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;

/**
 * Cartons Controller
 *
 * @property \App\Model\Table\CartonsTable $Cartons
 *
 * @method \App\Model\Entity\Carton[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartonsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Pallets', 'Items', 'Users'],
        ];
        $cartons = $this->paginate($this->Cartons);

        $this->set(compact('cartons'));
    }

    /**
     * View method
     *
     * @param string|null $id Carton id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $carton = $this->Cartons->get($id, [
            'contain' => ['Pallets', 'Items', 'Users'],
        ]);

        $this->set('carton', $carton);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carton = $this->Cartons->newEmptyEntity();
        if ($this->request->is('post')) {
            $carton = $this->Cartons->patchEntity($carton, $this->request->getData());
            if ($this->Cartons->save($carton)) {
                $this->Flash->success(__('The carton has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The carton could not be saved. Please, try again.'));
        }
        $pallets = $this->Cartons->Pallets->find('list', ['limit' => 200]);
        $items = $this->Cartons->Items->find('list', ['limit' => 200]);
        $users = $this->Cartons->Users->find('list', ['limit' => 200]);
        $this->set(compact('carton', 'pallets', 'items', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Carton id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carton = $this->Cartons->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $carton = $this->Cartons->patchEntity($carton, $this->request->getData());
            if ($this->Cartons->save($carton)) {
                $this->Flash->success(__('The carton has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The carton could not be saved. Please, try again.'));
        }
        $pallets = $this->Cartons->Pallets->find('list', ['limit' => 200]);
        $items = $this->Cartons->Items->find('list', ['limit' => 200]);
        $users = $this->Cartons->Users->find('list', ['limit' => 200]);
        $this->set(compact('carton', 'pallets', 'items', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Carton id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carton = $this->Cartons->get($id);
        if ($this->Cartons->delete($carton)) {
            $this->Flash->success(__('The carton has been deleted.'));
        } else {
            $this->Flash->error(__('The carton could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
    * editPalletCartons
    * @param palletID $palletId id of pallet
    * @return mixed
    */
    public function editPalletCartons($palletId = null)
    {
        $user = $this->Authentication->getIdentity();

        if (!$this->Cartons->Pallets->exists($palletId)) {
            throw new NotFoundException('Pallet Id incorrect or missing');
        }
        $palletCartons = $this->Cartons->Pallets->find(
            'all',
            [
                'conditions' => [
                    'Pallets.id' => $palletId,
                ],
            ]
        )->contain(['Cartons', 'Shipments', 'Items'])->first();


        if (isset($palletCartons['shipment']['shipped']) && (bool)$palletCartons['shipment']['shipped']) {
            $this->Flash->error('Cannot edit cartons on a pallet that is already shipped');

            return $this->redirect($this->request->referer(false));
        }

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            $update = array_filter($data['cartons'], function ($item) {
                return $item['count'] > 0 && $item['production_date'];
            });

            $delete = array_filter($data['cartons'], function ($item) {
                return $item['count'] == 0 && $item['id'] > 0;
            });

            $total = array_sum(Hash::extract($update, '{n}.count'));

            $palletEntity = $this->Cartons->Pallets->get($palletId);

            $palletPatched = $this->Cartons->Pallets->patchEntity($palletEntity, [
                'id' => $palletId,
                'qty' => $total,
                'qty_user_id' => $user->get('id'),
            ]);

            if ($this->Cartons->Pallets->save($palletPatched)) {
                $this->log('Updated pallet total after carton edit success!');
            } else {
                $this->log('Failed to update pallet record after carton edit');
            }

            $deleteIds = Hash::extract($delete, '{n}.id');
            $updateIds = Hash::extract($update, '{n}.id');

            $deleteOK = false;
            $updateOK = false;
            if ($deleteIds) {
                if (
                    $this->Cartons->deleteAll(
                        [
                            'Carton.id IN' => $deleteIds,
                        ]
                    )
                ) {
                    $deleteOK = true;
                } else {
                    $this->Flash->error('Delete Error');
                };
            }

            if ($update) {
                $entities = $this->Cartons->find()->where(['id IN' => $updateIds]);
                foreach($update as $k => $v) {
                    $update[$k]['user_id'] = $user->get('id');
                }
                $patched = $this->Cartons->patchEntities($entities, $update);
                foreach ($patched as $p) {
                    $this->log(print_r($p->getErrors(), true));
                }
              
                if ($this->Cartons->saveMany($patched)) {
                    $updateOK = true;
                } else {
                    $validationErrors = $this->Cartons->validationErrors;
                    $errorText = $this->Cartons->flattenAndFormatValidationErrors($validationErrors);
                    if ($errorText) {
                        $msg = __('<strong>Update Error: </strong> %s', $errorText);
                    } else {
                        $msg = '<strong>Update Error</strong>';
                    }

                    $this->Flash->error($msg);
                };
            }

            if (($update && $updateOK) || ($deleteIds && $deleteOK)) {
                $this->Flash->success("Successfully updated carton records");
              
                return $this->redirect($this->request->getData('referer'));
            }
        }
        $cartons = $palletCartons['cartons'];
        array_push($cartons, [
            'count' => '',
            'best_before' => '',
            'pallet_id' => $palletId,
        ]);

        $palletCartons['cartons'] = $cartons;

        if ($user) {
            $palletCartons['pallets']['qty_user_id'] = $user->get('id');
        }

        $referer = $this->request->referer(false);
        
        $this->set(compact('palletCartons', 'referer'));
    }
}