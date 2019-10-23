<?php
App::uses('AppController', 'Controller');

/**
 * Shipments Controller
 *
 * @property Shipment $Shipment
 * @property PaginatorComponent $Paginator
 */
class ShipmentsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator', 'ReactEmbed'];

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function update_shipment_types()
    {
        //$this->Shipment->recursive = -1;

        $this->Shipment->Behaviors->load('Containable');
        $shipments = $this->Shipment->find('all', [
            'contain' => [
                'Label' => [
                    'fields' => 'Label.id'
                ]
            ]
        ]);

        foreach ($shipments as $s) {
            $ids = Hash::extract($s, 'Label.{n}.id');
            //$this->log($ids);
            //$this->log($s);
            unset($s['Label']);
            $s['Shipment']['Label'] = $ids;

            if ($this->Shipment->save($s)) {
                $this->log('Updated ' . $s['Shipment']['id']);
            }
        }
        $this->render(false);
    }

    public function destinationLookup()
    {
        $search_term = $this->request->query['term'];

        $json_output = $this->Shipment->destinationLookup($search_term);

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }

        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    public function openShipments()
    {

        $this->Shipment->recursive = -1;
        $productTypes = $this->Shipment->Label->Item->ProductType->find('all', [
            'conditions' => [
                'ProductType.active' => 1,
                'ProductType.enable_pick_app' => 1
            ]
        ]);

        $productTypeIds = Hash::extract($productTypes, '{n}.ProductType.id');

        if (empty($productTypeIds)) {
            $shipments = [
                [
                    'Shipment' => [
                        'id' => 0,
                        'shipper' => "DISABLED:",
                        'destination' => "Pick stock function is not enabled. Enable it on Admin => Product Types screen"
                    ]
                ]
            ];
        } else {

            $shipments = $this->Shipment->find('all', [
                'conditions' => [
                    'Shipment.shipped' => 0,
                    // 'Shipment.shipment_type' => 'marg',
                     'Shipment.product_type_id IN' => $productTypeIds
                ],
                'order' => ['Shipment.id' => 'desc']
            ]);

        }

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
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
        //$this->Shipment->Behaviors->load('Containable');
        $this->Shipment->recursive = -1;

        $count = $this->Shipment->find(
            'count', [
                'conditions' => [
                    'Shipment.shipped' => 0
                ]
            ]
        );

        $this->Paginator->settings = [
            'Shipment' => [
                'order' => ['id' => 'desc'],
                'contain' => ['ProductType']
            ]
        ];
        $productTypes = $this->Shipment->Label->Item->ProductType->find('all', [
            'conditions' => [
                'ProductType.active' => 1
            ]
        ]);

        $this->set(compact('count', 'productTypes'));
        $this->set('shipments', $this->Paginator->paginate());
        $this->set('_serialize', ['shipments']);
    }

    /**
     * pdf pick list
     *
     */

    public function pdfPickList($id = null)
    {
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        // turn off debug output
        //Configure::write('debug', 0);

        $this->Shipment->recursive = 0;
        $this->Shipment->Behaviors->load('Containable');

        $pl_options = [
            'conditions' => ['Label.shipment_id' => $id],
            'contain' => [
                'Item',
                'Location'
            ],
            'order' => [
                'Item.code' => 'ASC',
                'Location.location' => 'ASC',
                'Label.pl_ref' => 'ASC'
            ]
        ];

        $pallets = $this->Shipment->Label->find('all', $pl_options);

        $pl_count = $this->Shipment->Label->find('count', $pl_options);

        $pl_groups = $pl_options = [
            'conditions' => ['Label.shipment_id' => $id],
            'fields' => [
                'Label.id',
                'COUNT(Label.item_id) as Pallets',
                'SUM(Label.qty) as Total',
                'Label.item_id',
                'Item.description',
                'Item.code'
            ],
            'contain' => [
                'Item'
            ],
            'group' => ['Item.code'],
            'order' => ['Item.code' => 'ASC']
        ];

        $groups = $this->Shipment->Label->find('all', $pl_groups);

        $options = [
            'conditions' => ['Shipment.' . $this->Shipment->primaryKey => $id]
        ];

        $shipment = $this->Shipment->find('first', $options);

        $this->layout = 'pdf/default';
        $file_name = $shipment['Shipment']['shipper'] . '_pick_list.pdf';
        $this->response->type('pdf');
        $this->set(compact(
            'file_name',
            'shipment', 'pallets', 'pl_count', 'groups'));
    }

    /*
     * mobile simplified view
     */

    /**
     * @param $id
     */
    public function viewplain($id = null)
    {
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        // turn off debug output
        Configure::write('debug', 0);

        $this->Shipment->recursive = 0;
        $this->Shipment->Behaviors->load('Containable');

        $pl_options = [
            'conditions' => ['Label.shipment_id' => $id],
            'contain' => [
                'Item',
                'Location'
            ],
            'order' => [
                'Item.code' => 'ASC',
                'Location.location' => 'ASC',
                'Label.pl_ref' => 'ASC'
            ]
        ];

        $pallets = $this->Shipment->Label->find('all', $pl_options);

        $pl_count = $this->Shipment->Label->find('count', $pl_options);

        $pl_groups = $pl_options = [
            'conditions' => ['Label.shipment_id' => $id],
            'fields' => [
                'Label.id', 'COUNT(Label.item_id) as Pallets',
                'SUM(Label.qty) as Total', 'Label.item_id',
                'Item.description', 'Item.code'
            ],
            'contain' => [
                'Item',
                'TruckRegistration',
                'Operator'
            ],
            'group' => ['Item.code'],
            'order' => ['Item.code' => 'ASC']
        ];

        $groups = $this->Shipment->Label->find('all', $pl_groups);

        $options = [
            'conditions' => ['Shipment.' . $this->Shipment->primaryKey => $id]
        ];

        $shipment = $this->Shipment->find('first', $options);

        $this->layout = 'mobile';

        $this->set(compact('shipment', 'pallets', 'pl_count', 'groups'));
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
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        $this->Shipment->recursive = 0;
        $this->Shipment->Behaviors->load('Containable');

        $options = [
            'conditions' => ['Shipment.' . $this->Shipment->primaryKey => $id],
            'contain' => [
                'Label' => [
                    'Location' => [
                        'fields' => ['Location.id', 'Location.location']
                    ]
                ]
            ]];

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }

        $this->set('shipment', $this->Shipment->find('first', $options));
        $this->set('_serialize', ['shipment']);
    }

    /**
     * pickStock React SPA
     *
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
     * @param $shipment_type
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
     * @return void
     */
    public function add($shipment_type = null)
    {

        $last = null;
        $error = null;

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }

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

                    if (!empty($this->request->data['Label'])) {
                        foreach ($this->request->data['Label'] as $key => $value) {
                            $update_labels[$key] = [
                                'Label' => [
                                    'id' => $value,
                                    'shipment_id' => $this->Shipment->id
                                ]
                            ];
                        }
                        if ($this->Shipment->Label->saveMany($update_labels)) {
                            if (!$this->request->is('ajax')) {
                                $this->Flash->success('The shipment ' . '<strong>' . h($shipper) . '</strong> has been saved.', [
                                    'clear' => true
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
                'Label.product_type_id' => $shipment_type,
                # not on hold
                 'OR' => [
                    'InventoryStatus.perms & ' . $perms,
                    'Label.inventory_status_id' => 0
                ],
                # hasn't been shipped
                 'Label.shipment_id' => 0,
                # has been put away
                 'NOT' => [
                    'Label.location_id' => 0
                ]

            ],
            'order' => [
                'Label.item' => 'ASC',
                'Label.pl_ref' => 'ASC'
            ],
            'contain' => ['InventoryStatus',
                'Location' => [
                    'fields' => ['Location.id', 'Location.location']
                ]]
        ];

        $shipment_labels = $this->Shipment->Label->find('all', $options);
        $label_count = $this->Shipment->Label->find('count', $options);

        $shipment_labels = $this->Shipment->markDisabled($shipment_labels);

        $disable_footer = true;
        $this->set('_serialize', ['error', 'last', 'shipment_labels']);
        $this->set(
            compact(
                'error',
                'last',
                'shipment_labels',
                'disable_footer',
                'label_count'
            )
        );
    }

    /**
     * @param $id
     */
    public function toggleShipped($id = null)
    {
        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }

        if ($this->request->is(['post', 'put'])) {
            $shipment = $this->Shipment->find('first', [
                'conditions' => [
                    'Shipment.id' => $id
                ]
            ]);

            //$this->log($shipment);

            $data = [
                'shipped' => !(bool)$shipment['Shipment']['shipped'],
                'id' => $id
            ];

            //unset($this->Shipment->validate['shipped']);
            $this->Shipment->set($shipment);
            if ($this->Shipment->save($data)) {
                $this->Flash->success("Successfully toggled shipped state");

            } else {
                $errorText = '';

                $ve = $this->Shipment->validationErrors;
                foreach (array_keys($ve) as $ak) {
                    $errorText .= join(' ', $ve[$ak]);
                };
                $this->Flash->error('Failed to toggle shipped state. ' . $errorText);
            }
            $this->redirect(['action' => 'index']);
        }

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
        $error = null;
        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }

        if (!$this->Shipment->exists($id)) {
            throw new NotFoundException(__('Invalid shipment'));
        }

        $this->Shipment->Behaviors->load('Containable');
        $options = [
            'conditions' => [
                'Shipment.' . $this->Shipment->primaryKey => $id
            ],
            'contain' => ['Label.Location']
        ];

        $thisShipment = $this->Shipment->find('first', $options);

        if ($this->request->is(['post', 'put'])) {

            $shipper = $this->request->data['Shipment']['shipper'];

            if (!empty($this->request->data['Label'])) {

                $labelsOnShipment = Hash::extract($this->request->data['Label'], '{n}.id');

                $updateLabels = $this->Shipment->Label->find(
                    'all',
                    [
                        'conditions' => [
                            'Label.shipment_id' => $id,
                            'Label.picked' => 1,
                            'NOT' => ['Label.id' => $labelsOnShipment]
                        ],
                        'fields' => ['id'],
                        'contain' => true
                    ]
                );

                $ids = Hash::extract($updateLabels, '{n}.Label.id');

                $this->Shipment->Label->updateAll(
                    ['Label.picked' => 0],
                    ['Label.id' => $ids]
                );

            }

            $this->Shipment->Label->updateAll(
                ['Label.shipment_id' => 0],
                ['Label.shipment_id' => $id]
            );

            if ($this->Shipment->saveAll($this->request->data)) {

                if (empty($this->request->data['Label'])) {
                    // counterCache fix when no labels.
                    $this->Shipment->save(
                        ['id' => $this->Shipment->id,
                            'label_count' => 0
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

        $shipment_labels = $this->Shipment->getShipmentLabels($id, $productTypeId);

        $labels = $this->Shipment->formatLabels($shipment_labels);

        $options = $this->Shipment->getShipmentLabelOptions($id, $productTypeId);

        unset($options['conditions']['AND']['OR']);
        $options['conditions']['AND']['Label.shipment_id'] = 0;
        $options['conditions']['AND']['Label.product_type_id'] = $productTypeId;

        $shipment_labels = $this->Shipment->Label->find('all', $options);
        $label_count = count($shipment_labels);

        $disabled = $this->Shipment->getDisabled($shipment_labels);
        $label_count -= count($disabled);
        $shipment_labels = $this->Shipment->markDisabled($shipment_labels);
        $this->log(['shlbl' => $shipment_labels, 'options' => $options]);
        if (isset($this->request->data['Label'])) {

            $selected_label_count = $this->Shipment->labelCount($this->request->data['Label']);

        } elseif (isset($this->request->data['Shipment']['Label'])) {

            $selected_label_count = $this->Shipment->labelCount($this->request->data['Shipment']['Label']);

        }

        $label_count -= $selected_label_count;

        $shipment_id = $id;

        $disable_footer = true;

        $referer = $this->request->referer();

        $this->set(
            compact(
                'error',
                'thisShipment',
                'shipment_labels',
                'referer',
                'labels',
                'disable_footer',
                'label_count',
                'selected_label_count',
                'disabled',
                'shipment_id'
            )
        );

        $this->set(
            '_serialize',
            [
                'error',
                'thisShipment',
                'shipment_labels'
            ]
        );
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
        $this->Shipment->id = $id;
        if (!$this->Shipment->exists()) {
            throw new NotFoundException(__('Invalid shipment'));
        }
        $this->request->allowMethod('post', 'delete');

        $options = [
            'conditions' => ['Label.shipment_id' => $this->Shipment->id]
        ];

        if ($this->Shipment->Label->find('count', $options) > 0) {

            // zero out the shipment_id so that
            // the pallets re-appear
            // also set picked to 0
            $this->Shipment->Label->updateAll(
                [
                    //field to change and new values
                     'Label.picked' => 0,
                    'Label.shipment_id' => 0
                ],
                // conditions
                ['Label.shipment_id' => $id]
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
