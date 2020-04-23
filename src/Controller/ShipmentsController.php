<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;

/**
 * Shipments Controller
 *
 * @property \App\Model\Table\ShipmentsTable $Shipments
 * @property \App\Controller\Component\ReactEmbedComponent $ReactEmbed
 * @method \App\Model\Entity\Shipment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipmentsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions([
            'editShipment',
            'destinationLookup',
            'addShipment',
            'openShipments',
            'view',
        ]);
    }

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
            'order' => [
                'id' => 'DESC',
            ],
        ];
        $shipments = $this->paginate($this->Shipments);
        $productTypes = $this->Shipments->ProductTypes->find('list')->where(['active' => 1]);

        $this->set(compact('shipments', 'productTypes'));
    }

    /**
     * View method
     *
     * @param  string|null                                        $id Shipment id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipment = $this->Shipments->get($id, [
            'contain' => ['ProductTypes', 'Pallets' => ['Locations']],
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
     * @param  string|null                                        $id Shipment id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
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
     * @param  string|null                                        $id Shipment id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipment = $this->Shipments->get($id);
        $shipper = $shipment->shipper;

        if ($this->Shipments->delete($shipment)) {
            $pallets = $this->Shipments->Pallets->updateAll(['shipment_id' => 0], ['shipment_id' => $id]);
            $this->Flash->success(__(
                'The shipment <strong>{0}</strong> has been deleted and <strong>{1}</strong> pallets released back to stock',
                $shipper,
                $pallets
            ), ['escape' => false]);
        } else {
            $errors = $this->Shipments->formatValidationErrors($shipment->getErrors());
            $this->Flash->error($errors);
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

    /**
     * addApp React SPA
     * @param  int  $shipment_type Product Type ID
     * @return void
     */
    public function process($operation = null, $productTypeOrId = null)
    {
        list($js, $css) = $this->ReactEmbed->getAssets(
            'shipment-app'
        );

        $baseUrl = $this->request->getAttribute('webroot');
        $productTypes = $this->Shipments->ProductTypes->find('list');

        $this->set(compact('js', 'css', 'baseUrl', 'productTypes', 'operation', 'productTypeOrId'));
    }

    /**
     * add method
     * @param  string $shipment_type oil or marg
     * @return mixed
     */
    public function addShipment($shipment_type = null)
    {
        $error = null;

        $perms = $this->Shipments->Pallets->getViewPermNumber('view_in_shipments');

        if ($this->request->is('post')) {
            $data = $this->request->getParsedBody();

            $pallets = $data['pallets'];

            $data['pallets'] = ['_ids' => $pallets];

            $newEntity = $this->Shipments->newEntity($data, [
                'associated' => ['Pallets'],
            ]);

            $shipment = $this->Shipments->save($newEntity);

            if (!$shipment) {
                $shipment = [
                    'data' => $data,
                    'error' => $newEntity->getErrors(),
                ];

                return $this->response->withStringBody(json_encode($shipment))->withType('application/json');
            }

            $shipmentId = $shipment->id;

            $palletData = [];

            /*   if (!empty($pallets)) {
                  foreach ($pallets as $pallet) {
                      $palletData[] = [
                          'id' => $pallet,
                          'shipment_id' => $shipmentId,
                      ];
                  }

                  $palletRecords = $this->Shipments->Pallets->find()
                      ->whereInList('id', $pallets)->toList();

                  $palletEntities = $this->Shipments->Pallets->patchEntities($palletRecords, $palletData);

                  $result = $this->Shipments->Pallets->saveMany($palletEntities);

                  return $this->response->withStringBody(json_encode([
                      $shipment, $palletData, $result, ]))->withType('application/json');
              } */

            return $this->response->withStringBody(json_encode([
                $shipment, ]))->withType('application/json');
        }

        $options = [
            'conditions' => [
                'OR' => [
                    // not on hold
                    'InventoryStatuses.perms & ' . $perms,
                    'Pallets.inventory_status_id' => 0,
                ],

                'Pallets.shipment_id' => 0,
                // hasn't been shipped

                'NOT' => [
                    // has been put away
                    'Pallets.location_id' => 0,
                ],
            ],
            'order' => [
                'Pallets.item' => 'ASC',
                'Pallets.pl_ref' => 'ASC',
            ],
            'contain' => ['InventoryStatuses',
                'Locations' => [
                    'fields' => ['Locations.id', 'Locations.location'],
                ], ],
        ];

        if (!is_null($shipment_type)) {
            $options['conditions']['Pallets.product_type_id'] = $shipment_type;
        }

        $shipment_labels = $this->Shipments->Pallets->find('all', $options)->toArray();

        $this->set(
            compact(
                'error',
                'shipment_labels',
            )
        );
        $this->set('_serialize', ['error', 'last', 'shipment_labels']);
    }

    /**
     * @param  int   $id ID of shipment
     * @return mixed
     */
    public function toggleShipped($id = null)
    {
        if (!$this->Shipments->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }

        if ($this->request->is(['post', 'put'])) {
            $shipment = $this->Shipments->get($id);

            $data = [
                'shipped' => !(bool)$shipment->shipped,
                'id' => $id,
            ];

            $patched = $this->Shipments->patchEntity($shipment, $data);

            if ($this->Shipments->save($patched)) {
                $toState = $patched->shipped ? 'shipped' : 'not-shipped';

                $this->Flash->success(
                    __('Shipment <strong>{0}</strong> marked as <strong>{1}</strong>', $shipment->shipper, $toState),
                    ['escape' => false]
                );
            } else {
                $errorText = '';

                $errors = $this->Shipments->formatValidationErrors($patched->getErrors()) ;

                $this->Flash->error($errors);
            }

            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * destinationLookup for react view
     * @return void
     */
    public function destinationLookup()
    {
        $term = $this->request->getQuery('term');

        $query = $this->Shipments->find();
        $destinations = $query->select([
            'value' => 'destination',
        ])->distinct(['destination'])->where([
            'destination LIKE' => '%' . $term . '%',
        ]);

        $this->set(compact('destinations'));

        $this->set('_serialize', 'destinations');
    }

    /**
     * edit method
     *
     * @throws \Cake\Http\Exception\NotFoundException
     * @param  string                                 $id Shipment ID
     * @return mixed
     */
    public function editShipment($id = null)
    {
        $error = null;

        $thisShipment = $this->Shipments->get($id, [
            'contain' => [
                'Pallets' => [
                    'Locations',
                    'InventoryStatuses',
                ],
            ],
        ]);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getParsedBody();
            $pallets = $data['pallets'];

            $originalPalletIds = Hash::extract($thisShipment->pallets, '{n}.id');

            $currentPalletIds = Hash::extract($pallets, '{n}.id');

            $removeShipmentIds = array_diff($originalPalletIds, $currentPalletIds);

            $errors = [];
            $msg = '';

            if ($removeShipmentIds) {
                $unlinkPallets = $this->Shipments->Pallets->find()
                    ->whereInList('id', $removeShipmentIds);
                /**
                 * @var \App\Model\Entity\Pallet $pallet Pallet entity
                 */
                foreach ($unlinkPallets as $pallet) {
                    $pallet->shipment_id = 0;
                    $this->Shipments->Pallets->save($pallet);
                    $errors[] = $pallet->getErrors();
                }

                if ($errors) {
                    $msg = $this->Shipments->formatValidationErrors($errors);
                }
                // remove pallets from shipment if needed
                // updateAll will not trigger beforeSave/afterSave
                //$this->Shipments->Pallets->updateAll(['shipment_id' => 0], [
                //    'id IN ' => $removeShipmentIds,
                //]);
            }

            $thisShipment->pallets = [];

            $thisShipment->pallets[] = $pallets;

            $patched = $this->Shipments->patchEntity($thisShipment, $data);

            // save the updated shipment
            $result = $this->Shipments->save($patched, [
                'associated' => 'Pallets',
            ]);

            //$ret = $this->Shipments->Pallets->updateCounterCache(null, null, false);

            $ret = $this->Shipments->Pallets->updateCounterCache(
                [
                    'Shipments' => [
                        'pallet_count' => [
                            'conditions' => ['shipment_id' => $id],
                        ],
                    ], ],
                null,
                false
            );

            if (!$patched->hasErrors() && empty($errors)) {
                $shipment = [
                    'shipment' => $result,
                    'data' => $data,
                    'error' => false,
                ];
            } else {
                $shipment = [
                    'error' => $patched->getErrors(),
                    'errorPallets' => $msg,
                    'shipment' => $result,
                    'data' => $data,
                ];
            }
            // tog($msg, json_encode($shipment));

            return $this->response->withStringBody(json_encode($shipment))->withType('application/json');
        }
        $productTypeId = $thisShipment->product_type_id;

        $options = $this->Shipments->getShipmentLabelOptions($id, $productTypeId);

        unset($options['conditions']['AND']['OR']);
        $options['conditions']['AND']['Pallets.shipment_id'] = 0;
        if ($productTypeId) {
            $options['conditions']['AND']['Pallets.product_type_id'] = $productTypeId;
        }

        $shipment_labels = $this->Shipments->Pallets->find('all', $options)->toArray();

        $this->set(
            compact(
                'error',
                'thisShipment',
                'shipment_labels'
            )
        );

        $this->set(
            '_serialize',
            [
                'error',
                'thisShipment',
                'shipment_labels',
            ]
        );
    }

    /**
     * pdfPickList
     *
     * @param  int  $id ID of Shipment
     * @return void
     */
    public function pdfPickList($id = null)
    {
        $shipment = $this->Shipments->get($id, [
            'contain' => [
                'Pallets' => [
                    'Locations',
                    'Items',
                ],
            ],
        ]);

        $pl_count = $this->Shipments->Pallets->find()->where(['shipment_id' => $id])->count();

        $groups = $this->Shipments->Pallets->find('all')
            ->select([
                'id' => 'Pallets.id',
                'pallet_count' => 'COUNT(Pallets.item_id)',
                'total' => 'SUM(Pallets.qty)',
                'item_id' => 'Pallets.item_id',
                'description' => 'Items.description',
                'code' => 'Items.code',
            ])
            ->where(['Pallets.shipment_id' => $id])
            ->contain(['Items'])->group(['Items.code'])
            ->order(['Items.code' => 'ASC']);

        $pallets = $this->Shipments->Pallets->find()
            ->where(['shipment_id' => $id])
            ->contain(['Locations']);

        $appName = Configure::read('applicationName');

        $keywords = Configure::read('PdfPickList.KeyWords');

        $suffix = Configure::read('PdfPickList.FileNameSuffix');

        $this->layout = 'pdf/default';

        $file_name = $shipment->shipper . $suffix;

        $this->response = $this->response->withType('pdf');

        $this->set(
            compact(
                'file_name',
                'shipment',
                'appName',
                'keywords',
                'pl_count',
                'groups',
                'pallets'
            )
        );
    }
}