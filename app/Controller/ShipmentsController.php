<?php
App::uses('AppController', 'Controller');

/**
 * Shipments Controller
 *
 * @property Shipment $Shipment
 * @property PaginatorComponent $Paginator
 * @property ReactEmbedComponent $ReactEmbed
 */
class ShipmentsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator', 'ReactEmbed'];

    /**
     * beforeFilter
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    /**
     * destinationLookup for react view
     * @return void
     */
    public function destinationLookup()
    {
        $search_term = $this->request->query['term'];

        $json_output = $this->Shipment->destinationLookup($search_term);

        $this->set(compact('json_output'));

        $this->set('_serialize', 'json_output');
    }

    /**
     * openShipments
     * @return void
     */
    public function openShipments()
    {
        $this->Shipment->recursive = -1;

        $productTypes = $this->Shipment->Pallet->Item->ProductType->find('all', [
            'conditions' => [
                'ProductType.active' => 1,
                'ProductType.enable_pick_app' => 1,
            ],
            'fields' => [
                'id',
            ],
        ]);

        $productTypeIds = Hash::extract($productTypes, '{n}.ProductType.id');

        if (empty($productTypeIds)) {
            $shipments = [
                [
                    'Shipment' => [
                        'id' => 0,
                        'shipper' => 'DISABLED:',
                        'destination' => 'Pick stock function is not enabled. Enable it on Admin => Product Types screen',
                    ],
                ],
            ];
        } else {
            $shipments = $this->Shipment->find('all', [
                'conditions' => [
                    'Shipment.shipped' => 0,
                    // 'Shipment.shipment_type' => 'marg',
                    'Shipment.product_type_id IN' => $productTypeIds,
                ],
                'order' => ['Shipment.id' => 'desc'],
            ]);
        }

        $this->set(compact('shipments'));

        $this->set('_serialize', ['shipments']);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        ////$this->Shipment->Behaviors->load('Containable');
        $this->Shipment->recursive = -1;

        $count = $this->Shipment->find(
            'count',
            [
                'conditions' => [
                    'Shipment.shipped' => 0,
                ],
            ]
        );

        $this->Paginator->settings = [
            'Shipment' => [
                'order' => ['id' => 'desc'],
                'contain' => ['ProductType'],
            ],
        ];
        $productTypes = $this->Shipment->Pallet->Item->ProductType->find('all', [
            'conditions' => [
                'ProductType.active' => 1,
            ],
        ]);

        $this->set(compact('count', 'productTypes'));
        $this->set('shipments', $this->Paginator->paginate());
        $this->set('_serialize', ['shipments']);
    }

    /**
     * pdfPickList
     *
     * @param int $id ID of Shipment
     * @return void
     */
    public function pdfPickList($id = null)
    {
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        // turn off debug output
        //Configure::write('debug', 0);

        $this->Shipment->recursive = 0;
        //$this->Shipment->Behaviors->load('Containable');

        $pl_options = [
            'conditions' => ['Pallet.shipment_id' => $id],
            'contain' => [
                'Item',
                'Location',
            ],
            'order' => [
                'Item.code' => 'ASC',
                'Location.location' => 'ASC',
                'Pallet.pl_ref' => 'ASC',
            ],
        ];

        $pallets = $this->Shipment->Pallet->find('all', $pl_options);

        $pl_count = $this->Shipment->Pallet->find('count', $pl_options);

        $pl_groups = $pl_options = [
            'conditions' => ['Pallet.shipment_id' => $id],
            'fields' => [
                'Pallet.id',
                'COUNT(Pallet.item_id) as Pallets',
                'SUM(Pallet.qty) as Total',
                'Pallet.item_id',
                'Item.description',
                'Item.code',
            ],
            'contain' => [
                'Item',
            ],
            'group' => ['Item.code'],
            'order' => ['Item.code' => 'ASC'],
        ];

        $groups = $this->Shipment->Pallet->find('all', $pl_groups);

        $options = [
            'conditions' => ['Shipment.' . $this->Shipment->primaryKey => $id],
        ];

        $shipment = $this->Shipment->find('first', $options);

        $appName = Configure::read('applicationName');

        $keywords = Configure::read('pdfPickListKeywords');

        $this->layout = 'pdf/default';

        $file_name = $shipment['Shipment']['shipper'] . '_pick_list.pdf';

        $this->response->type('pdf');

        $this->set(
            compact(
                'file_name',
                'shipment',
                'pallets',
                'appName',
                'keywords',
                'pl_count',
                'groups'
            )
        );
    }

    /**
     * @throws NotFoundException
     * @param int $id ID of Shipment
     * @return void
     */
    public function viewPlain($id = null)
    {
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        // turn off debug output
        Configure::write('debug', 0);

        $this->Shipment->recursive = 0;
        //$this->Shipment->Behaviors->load('Containable');

        $pl_options = [
            'conditions' => ['Pallet.shipment_id' => $id],
            'contain' => [
                'Item',
                'Location',
            ],
            'order' => [
                'Item.code' => 'ASC',
                'Location.location' => 'ASC',
                'Pallet.pl_ref' => 'ASC',
            ],
        ];

        $pallets = $this->Shipment->Pallet->find('all', $pl_options);

        $pl_count = $this->Shipment->Pallet->find('count', $pl_options);

        $pl_groups = $pl_options = [
            'conditions' => ['Pallet.shipment_id' => $id],
            'fields' => [
                'Pallet.id', 'COUNT(Pallet.item_id) as Pallets',
                'SUM(Pallet.qty) as Total', 'Pallet.item_id',
                'Item.description', 'Item.code',
            ],
            'contain' => [
                'Item',
                'TruckRegistration',
                'Operator',
            ],
            'group' => ['Item.code'],
            'order' => ['Item.code' => 'ASC'],
        ];

        $groups = $this->Shipment->Pallet->find('all', $pl_groups);

        $options = [
            'conditions' => ['Shipment.' . $this->Shipment->primaryKey => $id],
        ];

        $shipment = $this->Shipment->find('first', $options);

        $this->layout = 'mobile';

        $this->set(compact('shipment', 'pallets', 'pl_count', 'groups'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param int $id ID of Shipment
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        $this->Shipment->recursive = 0;
        //$this->Shipment->Behaviors->load('Containable');

        $options = [
            'conditions' => ['Shipment.' . $this->Shipment->primaryKey => $id],
            'contain' => [
                'Pallet' => [
                    'Location' => [
                        'fields' => [
                            'Location.id',
                            'Location.location',
                        ],
                    ],
                ],
            ],
        ];

        $this->set('shipment', $this->Shipment->find('first', $options));

        $this->set('_serialize', ['shipment']);
    }

    /**
     * pickStock React SPA
     *
     * @return void
     */
    public function pickStock()
    {
        list($js, $css, $baseUrl) = $this->ReactEmbed->getAssets(
            'pick-app',
            $this
        );

        $this->set(compact('js', 'css', 'baseUrl'));
    }

    /**
     * addApp React SPA
     * @param int $shipment_type Product Type ID
     * @return void
     */
    public function addApp($shipment_type = null)
    {
        list($js, $css, $baseUrl) = $this->ReactEmbed->getAssets(
            'shipment-app',
            $this
        );

        $this->set(compact('js', 'css', 'baseUrl'));
    }

    /**
     * add method
     * @param string $shipment_type oil or marg
     * @return mixed
     */
    public function add($shipment_type = null)
    {
        $last = null;
        $error = null;

        $perms = $this->Shipment->getViewPermNumber('view_in_shipments');

        if ($this->request->is('post')) {
            $this->Shipment->create();
            if ($this->request->data) {
                $shipment = $this->Shipment->save($this->request->data);

                if (!empty($shipment)) {
                    $shipper = $this->request->data['Shipment']['shipper'];

                    if (!$this->request->is('ajax')) {
                        $this->Flash->success('The shipment ' . '<strong>' . h($shipper) . '</strong> has been saved.');
                    }

                    if (!empty($this->request->data['Pallet'])) {
                        $update_labels = array_map(
                            function ($val) {
                                return [
                                    'Pallet' => [
                                        'id' => $val,
                                        'shipment_id' => $this->Shipment->id,
                                    ],
                                ];
                            },
                            $this->request->data['Pallet']
                        );

                        if ($this->Shipment->Pallet->saveMany($update_labels)) {
                            if (!$this->request->is('ajax')) {
                                $this->Flash->success('The shipment ' . '<strong>' . h($shipper) . '</strong> has been saved.', [
                                    'clear' => true,
                                ]);
                            } else {
                                $last = $this->Shipment->findById($this->Shipment->id);
                            }
                        }
                    }
                    if (!$this->request->is('ajax')) {
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    if (!$this->request->is('ajax')) {
                        $this->Flash->error(__('The shipment could not be saved. Please, try again.'));
                    } else {
                        $error = $this->Shipment->validationErrors;
                    }
                }
            }
        }

        $shipment_slug = 'mixed';

        $options = [
            'conditions' => [
                'Pallet.product_type_id' => $shipment_type,
                'OR' => [
                    // not on hold
                    'InventoryStatus.perms & ' . $perms,
                    'Pallet.inventory_status_id' => 0,
                ],

                'Pallet.shipment_id' => 0,
                // hasn't been shipped

                'NOT' => [
                    // has been put away
                    'Pallet.location_id' => 0,
                ],
            ],
            'order' => [
                'Pallet.item' => 'ASC',
                'Pallet.pl_ref' => 'ASC',
            ],
            'contain' => ['InventoryStatus',
                'Location' => [
                    'fields' => ['Location.id', 'Location.location'],
                ], ],
        ];

        $shipment_labels = $this->Shipment->Pallet->find('all', $options);
        $pallet_count = $this->Shipment->Pallet->find('count', $options);

        $shipment_labels = $this->Shipment->markDisabled($shipment_labels);

        $disable_footer = true;

        $this->set(
            compact(
                'error',
                'last',
                'shipment_labels',
                'disable_footer',
                'pallet_count'
            )
        );
        $this->set('_serialize', ['error', 'last', 'shipment_labels']);
    }

    /**
     * @param int $id ID of shipment
     * @return mixed
     */
    public function toggleShipped($id = null)
    {
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }

        if ($this->request->is(['post', 'put'])) {
            $shipment = $this->Shipment->find('first', [
                'conditions' => [
                    'Shipment.id' => $id,
                ],
            ]);

            $data = [
                'shipped' => !(bool)$shipment['Shipment']['shipped'],
                'id' => $id,
            ];

            $this->Shipment->set($shipment);
            if ($this->Shipment->save($data)) {
                $toState = !(bool)$shipment['Shipment']['shipped'] ? 'shipped' : 'not-shipped';
                $shipper = $shipment['Shipment']['shipper'];
                $this->Flash->success(__('Shipment <strong>%s</strong> marked as <strong>%s</strong>', $shipper, $toState));
            } else {
                $errorText = '';

                $ve = $this->Shipment->validationErrors;
                foreach (array_keys($ve) as $ak) {
                    $errorText .= join(' ', $ve[$ak]);
                };
                $this->Flash->error('Failed to toggle shipped state. ' . $errorText);
            }

            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id Shipment ID
     * @return mixed
     */
    public function edit($id = null)
    {
        $error = null;

        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }

        //$this->Shipment->Behaviors->load('Containable');

        $options = [
            'conditions' => [
                'Shipment.' . $this->Shipment->primaryKey => $id,
            ],
            'contain' => [
                'Pallet.Location',
            ],
        ];

        $thisShipment = $this->Shipment->find('first', $options);

        if ($this->request->is(['post', 'put'])) {
            $shipper = $this->request->data['Shipment']['shipper'];

            if ($this->Shipment->saveAll($this->request->data)) {
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
                        $this->Shipment->Pallet->saveAll($pwor);
                    }
                } else {
                    // if there are no labels then remove them all
                    $this->Shipment->Pallet->updateAll(
                        ['Pallet.shipment_id' => 0],
                        ['Pallet.shipment_id' => $id]
                    );

                    // and update counterCache to be zero`
                    $this->Shipment->save(
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
                    $error = $this->Shipment->validationErrors;
                }
            }
        } else {
            $this->request->data = $thisShipment;
        }
        $productTypeId = $thisShipment['Shipment']['product_type_id'];

        $options = $this->Shipment->getShipmentLabelOptions($id, $productTypeId);

        unset($options['conditions']['AND']['OR']);
        $options['conditions']['AND']['Pallet.shipment_id'] = 0;
        if ($productTypeId) {
            $options['conditions']['AND']['Pallet.product_type_id'] = $productTypeId;
        }

        $shipment_labels = $this->Shipment->Pallet->find('all', $options);

        $disabled = $this->Shipment->getDisabled($shipment_labels);

        $shipment_labels = $this->Shipment->markDisabled($shipment_labels);

        $disable_footer = true;

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
     * delete method
     *
     * @throws NotFoundException
     * @param int $id Shipment ID
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->Shipment->id = $id;
        if (!$this->Shipment->exists()) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        $this->request->allowMethod('post', 'delete');

        $options = [
            'conditions' => ['Pallet.shipment_id' => $this->Shipment->id],
        ];

        if ($this->Shipment->Pallet->find('count', $options) > 0) {
            // zero out the shipment_id so that
            // the pallets re-appear
            // also set picked to 0
            $this->Shipment->Pallet->updateAll(
                [
                    //field to change and new values
                    'Pallet.picked' => 0,
                    'Pallet.shipment_id' => 0,
                ],
                // conditions
                ['Pallet.shipment_id' => $id]
            );
        };

        if ($this->Shipment->delete()) {
            $this->Flash->success(__('The shipment has been deleted.'));
        } else {
            $this->Flash->error(__('The shipment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}