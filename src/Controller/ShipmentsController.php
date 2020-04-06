<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
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
        $shipper = $shipment->shipper;

        if ($shipment->shipped) {
            $this->Flash->error(__('This shipment is marked as shipped it cannot be deleted'));
            return $this->redirect($this->request->referer());
        }

        if ($this->Shipments->delete($shipment)) {
            $pallets = $this->Shipments->Pallets->updateAll(['shipment_id' => 0], ['shipment_id' => $id]);
            $this->Flash->success(__('The shipment "{0}" has been deleted and {1} pallets released to stock', $shipper, $pallets));
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

    /**
     * addApp React SPA
     * @param int $shipment_type Product Type ID
     * @return void
     */
    public function process($shipment_type = null)
    {
        list($js, $css) = $this->ReactEmbed->getAssets(
            'shipment-app'
        );

        $baseUrl = $this->request->getAttribute('webroot');

        $this->set(compact('js', 'css', 'baseUrl'));
    }

    /**
     * add method
     * @param string $shipment_type oil or marg
     * @return mixed
     */
    public function addShipment($shipment_type = null)
    {
        $error = null;

        $perms = $this->Shipments->Pallets->getViewPermNumber('view_in_shipments');

        if ($this->request->is('post')) {
            $data = json_decode($this->request->input(), true);

            $pallets = $data['pallets'];
            unset($data['pallets']);

            $newEntity = $this->Shipments->newEntity($data);

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
        }

        $options = [
            'conditions' => [
                'Pallets.product_type_id' => $shipment_type,
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

        $shipment_labels = $this->Shipments->Pallets->find('all', $options)->toArray();

        $shipment_labels = $this->Shipments->markDisabled($shipment_labels);

        $this->set(
            compact(
                'error',
                'shipment_labels',
            )
        );
        $this->set('_serialize', ['hijames', 'error', 'last', 'shipment_labels']);
    }

    /**
     * @param int $id ID of shipment
     * @return mixed
     */
    public function toggleShipped($id = null)
    {
        if (!$this->Shipments->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }

        if ($this->request->is(['post', 'put'])) {
            $shipment = $this->Shipments->find('first', [
                'conditions' => [
                    'Shipment.id' => $id,
                ],
            ]);

            $data = [
                'shipped' => !(bool)$shipment['Shipment']['shipped'],
                'id' => $id,
            ];

            $this->Shipments->set($shipment);
            if ($this->Shipments->save($data)) {
                $toState = !(bool)$shipment['Shipment']['shipped'] ? 'shipped' : 'not-shipped';
                $shipper = $shipment['Shipment']['shipper'];
                $this->Flash->success(__('Shipment <strong>%s</strong> marked as <strong>%s</strong>', $shipper, $toState));
            } else {
                $errorText = '';

                $ve = $this->Shipments->validationErrors;
                foreach (array_keys($ve) as $ak) {
                    $errorText .= join(' ', $ve[$ak]);
                };
                $this->Flash->error('Failed to toggle shipped state. ' . $errorText);
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
     * @throws NotFoundException
     * @param string $id Shipment ID
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
            unset($data['pallets']);

            $originalPalletIds = Hash::extract($thisShipment->pallets, '{n}.id');
            $currentPalletIds = Hash::extract($pallets, '{n}.id');

            $removeShipmentIds = array_diff($originalPalletIds, $currentPalletIds);
            tog(['rsi' => $removeShipmentIds, 'orig' => $originalPalletIds, 'curr' => $currentPalletIds]);

            $patched = $this->Shipments->patchEntity($thisShipment, $data);

            // save the updated shipment
            $result = $this->Shipments->save($patched, [
                'associated' => 'Pallets',
            ]);

            if ($removeShipmentIds) {
                tog('Remove shipment IDs from Pallets');
                tog($removeShipmentIds);
                // remove pallets from shipment if needed
                $this->Shipments->Pallets->updateAll(['shipment_id' => 0], [
                    'id IN ' => $removeShipmentIds,
                ]);
            }

            if ($currentPalletIds) {
                tog('Save current Pallets');
                $palletEntities = $this->Shipments->Pallets->find()->whereInList('id', $currentPalletIds);

                $patchedEntities = $this->Shipments->Pallets->patchEntities($palletEntities, $pallets);

                $palletResult = $this->Shipments->Pallets->saveMany($patchedEntities);
            }

            if ($result) {
                $shipment = [
                    'shipment' => $result,

                    'data' => $data,
                    'error' => false,
                ];
            } else {
                $shipment = [
                    'shipment' => $result,
                    'data' => $data,
                    'error-shipment' => $patched->getErrors(),
                ];
            }
            return $this->response->withStringBody(json_encode($shipment))->withType('application/json');

            /*             $shipper = $this->request->data['Shipment']['shipper'];

                    if ($this->Shipments->saveAll($this->request->data)) {
                        if (!empty($this->request->data['Pallet'])) {
                            $requestedLabelIdsOnShipment = Hash::extract($this->request->data['Pallet'], '{n}.id');

                            $previousLabels = Hash::extract(
                                $thisShipment,
                                'Pallet'
                            );

                            $previousIds = Hash::extract(
                                $thisShipment,
                                'Pallet.id'
                            );

                            $previousWithoutRequested = array_filter(
                                $previousLabels,
                                function ($val) use ($requestedLabelIdsOnShipment) {
                                    return !in_array(
                                        $val['id'],
                                        $requestedLabelIdsOnShipment
                                    );
                                }
                            );

                            $pwor = array_map(
                                function ($val) {
                                    $val['picked'] = 0;
                                    $val['shipment_id'] = 0;

                                    return $val;
                                },
                                $previousWithoutRequested
                            );

                            // this removes labels that have been deselected
                            // and removes 'picked'
                            if ($pwor) {
                                $this->Shipments->Pallets->saveAll($pwor);
                            }
                        } else {
                            // if there are no labels then remove them all
                            $this->Shipments->Pallets->updateAll(
                                ['Pallet.shipment_id' => 0],
                                ['Pallet.shipment_id' => $id]
                            );

                            // and update counterCache to be zero`
                            $this->Shipments->save(
                                [
                                    'id' => $id,
                                    'pallet_count' => 0,
                                ]
                            );
                        }

                        if (!$this->request->is('ajax')) {
                            $this->Flash->success('The shipment <strong>' . h($shipper) . '</strong> has been saved.');

                            return $this->redirect(
                                $this->request->data['Shipment']['referer']
                            );
                        }
                    } else {
                        if (!$this->request->is('ajax')) {
                            $this->Flash->error('The shipment <strong>' . h($shipper) . '</strong> could not be saved. Please, try again.');
                        } else {
                            $error = $this->Shipments->validationErrors;
                        }
                    }
                } else {
                    $this->request->data = $thisShipment; */
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
     * @param int $id ID of Shipment
     * @return void
     */
    public function pdfPickList($id = null)
    {
        $shipment = $this->Shipments->find()->where(['id' => $id])
        ->contain(
            [
                'Pallets' => [
                    'Locations',
                    'Items', ],
            ],
        )->first()->toArray();

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
            ->order(['Items.code' => 'ASC'])->toArray();

        $pallets = $this->Shipments->Pallets->find('')
            ->where(['shipment_id' => $id])
            ->contain(['Locations'])
            ->toArray();

        $appName = Configure::read('applicationName');

        $keywords = Configure::read('pdfPickListKeywords');

        $this->layout = 'pdf/default';

        $file_name = $shipment['shipper'] . '_pick_list.pdf';

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