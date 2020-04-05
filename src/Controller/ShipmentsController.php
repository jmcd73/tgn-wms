<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Hash;

/**
 * Shipments Controller
 *
 * @property \App\Model\Table\ShipmentsTable $Shipments
 * @property \App\Controller\Component\ReactEmbedComponent $ReactEmbed
 *
 * @method \App\Model\Entity\Shipment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipmentsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('ReactEmbed');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductTypes'],
        ];
        $shipments = $this->paginate($this->Shipments);

        $this->set(compact('shipments'));
    }

    /**
     * View method
     *
     * @param string|null $id Shipment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipment = $this->Shipments->get($id, [
            'contain' => ['ProductTypes',  'Pallets' => ['Locations']],
        ]);

        $this->set('shipment', $shipment);
        $this->set('_serialize', 'shipment');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipment = $this->Shipments->newEmptyEntity();
        if ($this->request->is('post')) {
            $shipment = $this->Shipments->patchEntity($shipment, $this->request->getData());
            if ($this->Shipments->save($shipment)) {
                $this->Flash->success(__('The shipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shipment could not be saved. Please, try again.'));
        }

        $productTypes = $this->Shipments->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('shipment', 'productTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shipment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipment = $this->Shipments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipment = $this->Shipments->patchEntity($shipment, $this->request->getData());
            if ($this->Shipments->save($shipment)) {
                $this->Flash->success(__('The shipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shipment could not be saved. Please, try again.'));
        }

        $productTypes = $this->Shipments->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('shipment', 'productTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shipment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipment = $this->Shipments->get($id);
        if ($this->Shipments->delete($shipment)) {
            $this->Flash->success(__('The shipment has been deleted.'));
        } else {
            $this->Flash->error(__('The shipment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
    * pickStock React SPA
    *
    * @return void
    */
    public function pickStock()
    {
        list($js, $css) = $this->ReactEmbed->getAssets(
            'pick-app'
        );
        $baseUrl = $this->request->getAttribute('webroot');

        $this->set(compact('js', 'css', 'baseUrl'));
    }

    /**
    * openShipments
    * @return void
    */
    public function openShipments()
    {
        $this->Shipments->recursive = -1;

        $productTypes = $this->Shipments->Pallets->Items->ProductTypes->find('all', [
            'conditions' => [
                'ProductTypes.active' => 1,
                'ProductTypes.enable_pick_app' => 1,
            ],
            'fields' => [
                'id',
            ],
        ])->toArray();

        $productTypeIds = Hash::extract($productTypes, '{n}.id');

        if (empty($productTypeIds)) {
            $shipments = [
                [
                    'Shipments' => [
                        'id' => 0,
                        'shipper' => 'DISABLED:',
                        'destination' => 'Pick stock function is not enabled. Enable it on Admin => Product Types screen',
                    ],
                ],
            ];
        } else {
            $shipments = $this->Shipments->find('all', [
                'conditions' => [
                    'Shipments.shipped' => 0,
                    // 'Shipment.shipment_type' => 'marg',
                    'Shipments.product_type_id IN' => $productTypeIds,
                ],
                'order' => ['Shipments.id' => 'desc'],
            ]);
        }

        $this->set(compact('shipments'));

        $this->set('_serialize', ['shipments']);
    }
}