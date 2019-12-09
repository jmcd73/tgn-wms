<?php
/**
 *
 */
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
App::import('Vendor', 'CabLabel');

/**
 * Pallets Controller
 *
 * @property Pallet $Pallet
 * @property PaginatorComponent $Paginator
 * @property PrintLogicComponent $PrintLogic
 */
class PalletsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator', 'PrintLogic'];

    /**
     * @var mixed
     */
    public $showInSelectedControllerActionList = true;

    /**
     * BeforeFilter beforFilter
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('palletReferenceLookup');
        $this->Auth->deny(['editPallet', 'bulkStatusRemove', 'delete']);
    }

    /**
     * @param URLDate $url_date provided on command line
     *
     * @return void
     */
    public function formatReport($url_date = null)
    {
        if ($this->request->is('POST')) {
            if (!empty($this->request->data['Pallet']['start_date'])) {
                $query_date = $this->request->data['Pallet']['start_date'];
            } elseif (!empty($this->request->data['Pallet']['report_date'])) {
                $query_date = $this->request->data['Pallet']['report_date'];
            }

            if (!empty($url_date)) {
                $query_date = $url_date;
            }

            $reports = $this->Pallet->enumShifts($query_date);

            $this->set('reports', $reports['reports']);
            $this->set('shift_date', $this->Pallet->arrayToMysqlDate($query_date));
            $this->set('xml_shift_report', $reports['xml_shift_report']);
        }

        $this->loadModel('Shift');

        $shifts = $this->Shift->find(
            'list',
            [
                'conditions' => [
                    'Shift.active' => 1,
                    'Shift.for_prod_dt' => 0
                ]
            ]
        );

        if (isset($params)) {
            $this->set('params', $params);
        }
        $this->set('shifts', $shifts);
        $this->set("_serialize", ['xml_shift_report']);
    }

    /**
     * @param URLDate $url_date provided on command line
     *
     * @return void
     */
    public function shiftReport($url_date = null)
    {
        if ($this->request->is('POST')) {
            if (!empty($this->request->data['Pallet']['start_date'])) {
                $query_date = $this->request->data['Pallet']['start_date'];
            } elseif (!empty($this->request->data['Pallet']['report_date'])) {
                $query_date = $this->request->data['Pallet']['report_date'];
            }

            if (!empty($url_date)) {
                $query_date = $url_date;
            }

            $reports = $this->Pallet->shiftReport($query_date);

            $this->set('reports', $reports['reports']);
            $this->set('shift_date', $this->Pallet->arrayToMysqlDate($query_date));
            $this->set('xml_shift_report', $reports['xml_shift_report']);
        }

        $this->loadModel('Shift');

        $shifts = $this->Shift->find(
            'list',
            [
                'conditions' => [
                    'Shift.active' => 1,
                    'Shift.for_prod_dt' => 0
                ]
            ]
        );

        if (isset($params)) {
            $this->set('params', $params);
        }
        $this->set('shifts', $shifts);
        $this->set("_serialize", ['xml_shift_report']);
    }

    /**
     * viewPartPalletsCartons
     *
     * @return void
     */
    public function viewPartPalletsCartons()
    {
        $view_perms = $this->Pallet->getViewPermNumber('view_in_stock');

        $options = [
            'conditions' => [
                'OR' => [
                    'InventoryStatus.perms & ' . $view_perms,
                    'Pallet.inventory_status_id' => 0
                ]
            ],
            'limit' => 20,
            'joins' => [
                [
                    'table' => 'cartons',
                    'alias' => 'Carton',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Carton.pallet_id = Pallet.id'
                    ]
                ]
            ],
            'contain' => [
                'Item',
                'Shipment',
                'Carton',
                'Location',
                'InventoryStatus'
            ],
            'fields' => [
                'InventoryStatus.id',
                'InventoryStatus.name',
                'Pallet.item_id',
                'Pallet.description',
                'Pallet.qty',
                'Item.code',
                'Pallet.pl_ref',
                'Pallet.sscc_fmt',
                'bb_date',
                'print_date',
                'Location.location',
                'Shipment.shipper',
                'Shipment.shipped',
                'Item.quantity',
                'COUNT(Carton.id) AS cartonRecordCount'
            ],
            'countFields' => [
                'Pallet.item_id',
                'Pallet.description',
                'Pallet.qty',
                'Item.code',
                'Pallet.pl_ref',
                'Pallet.sscc_fmt',
                'bb_date',
                'print_date',
                'Location.location',
                'Shipment.shipper',
                'Shipment.shipped',
                'Item.quantity',
                'COUNT(Carton.id) AS cartonRecordCount'
            ],
            'group' => [
                'Pallet.id'
            ],
            'having' => [
                'OR' => [
                    [
                        'OR' => [
                            'Shipment.shipped IS NULL',
                            'Shipment.shipped = 0'
                        ],
                        [
                            'cartonRecordCount > 1'
                        ]
                    ],
                    [
                        'Item.quantity <> Pallet.qty',
                        'OR' => [
                            'Shipment.shipped IS NULL',
                            'Shipment.shipped = 0'
                        ]
                    ]
                ]
            ],
            'order' => [
                'Pallet.print_date' => 'DESC'
            ],
            'recursive' => -1
        ];

        // This behavior implements paginate and paginateCount
        // because the default paginateCount will not work with the HAVING clause
        $this->Pallet->Behaviors->load('Cartons');

        $this->Paginator->settings = $options;

        $pallets = $this->Paginator->paginate();
        $this->set(compact('pallets'));
    }

    /**
     * @param int StatusID $status_id the id to change
     *
     * @return void
     */
    public function bulkStatusRemove($status_id = null)
    {
        $view_perms = $this->Pallet->getViewPermNumber('view_in_remove_status');

        if ($this->request->is(["POST", 'PUT']) && !empty($this->request->data['Pallet'])) {
            $inventory_status_note = $this->Pallet->inventoryStatusNote($this->request->data['Pallet']);

            $update_statuses = [];
            foreach ($this->request->data['Pallet'] as $pallet) {
                if (isset($pallet['inventory_status_id'])) {
                    $pallet['inventory_status_note'] = $inventory_status_note;
                    $update_statuses[] = $pallet;
                }
            }

            if (!empty($update_statuses)) {
                if (
                    $this->Pallet->saveMany(
                        $update_statuses,
                        ['validate' => false]
                    )
                ) {
                    $this->Flash->success(__('The data has been saved.'));
                    $this->request->data['Pallet']['inventory_status_note_global'] = "";
                };
            }
        }

        $this->Pallet->recursive = 0;
        $this->Paginator->settings = [
            'order' => [
                'Pallet.id' => 'DESC'
            ],
            'limit' => 500,
            'maxLimit' => 3000
        ];

        if ($status_id === null) {
            $this->Paginator->settings['conditions'] = [
                'Pallet.shipment_id' => 0
            ];
        } else {
            $this->Paginator->settings['conditions'] = [
                'Pallet.inventory_status_id' => $status_id,
                'Pallet.shipment_id' => 0,
                'InventoryStatus.perms & ' . $view_perms
            ];
        }

        $pallets = $this->Paginator->paginate();
        $status_options = [
            'recursive' => -1,
            'conditions' => [
                'InventoryStatus.perms & ' . $view_perms
            ]
        ];

        $statuses = $this->Pallet->InventoryStatus->find('all', $status_options);
        $status_list = $this->Pallet->InventoryStatus->find('list', $status_options);

        $status_list[0] = 'No Status';
        unset($status_list[$status_id]);

        ksort($status_list);

        // debug($pallets);
        $disable_footer = true;
        $this->set(
            compact(
                'pallets',
                'statuses',
                'status_id',
                'status_list',
                'disable_footer'
            )
        );
    }

    /**
     * @param array $user User array object
     *
     * @return mixed
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
     * Action updateMinDaysLife for shell script to do bulk update
     *
     * @return void
     */
    public function updateMinDaysLife()
    {
        $this->Pallet->recursive = -1;

        //$this->Pallet->Behaviors->load('Containable');

        $global_life = $this->Pallet->getGlobalMinDaysLife();

        $shipments = $this->Pallet->find('all', [
            'contain' => 'Item',
            'conditions' => [
                'Pallet.min_days_life' => 0
            ]
        ]);

        foreach ($shipments as $shipment) {
            $item = $shipment['Item']['min_days_life'];

            $shipment['Pallet']['min_days_life'] = (bool)$item ? $item : $global_life;
            $pl_ref = $shipment['Pallet']['pl_ref'];

            unset($shipment['Item']);

            $save_this = [
                'id' => $shipment['Pallet']['id'],
                'modified' => false,
                'min_days_life' => (bool)$item ? $item : $global_life
            ];

            if ($this->Pallet->save($save_this)) {
                // ok
                echo "Updating " . $pl_ref . "\n";
            }
        }

        $this->autoRender = false;
        //$this->Shipment->save($this->request->data)
    }

    /**
     * batchLookup used by Pallets/lookup to get list of queried batch numbers from fragment
     *
     * @return void
     */
    public function batchLookup()
    {
        $search_term = $this->request->query['term'];

        $json_output = $this->Pallet->batchLookup($search_term);

        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    /**
     * palletReferenceLookup find pl_ref and return list to typeahead for Pallets/lookup
     *
     * @return void
     */
    public function palletReferenceLookup()
    {
        $search_term = $this->request->query['term'];
        $json_output = $this->Pallet->palletReferenceLookup($search_term);
        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    /**
     * itemLookup for Pallets/lookup
     *
     * @return void
     */
    public function itemLookup()
    {
        $search_term = $this->request->query['term'];

        $json_output = $this->Pallet->Item->itemLookup($search_term);

        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Pallet->recursive = 0;
        $this->Paginator->settings = [
            'order' => [
                'Pallet.id' => 'DESC'
            ],
            'limit' => 500
        ];
        $this->set('pallets', $this->Paginator->paginate());
    }

    /**
     * @return mixed
     */
    public function lookupSearch()
    {
        // the page we will redirect to
        $url['action'] = 'lookup';

        // build a URL will all the search elements in it
        // the resulting URL will be
        // example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
        foreach ($this->request->data as $k => $v) {
            foreach ($v as $kk => $vv) {
                $url[$k . '.' . $kk] = $vv;
            }
        }

        // redirect the user to the url

        return $this->redirect($url, null, true);
    }

    /**
     * lookup action for pallet track
     *
     * @return void
     */
    public function lookup()
    {
        $options = [];

        if (!empty($this->passedArgs)) {
            $options = $this->Pallet->formatLookupActionConditions(
                $this->passedArgs
            );
            $this->request->data = $this->Pallet->formatLookupRequestData(
                $this->passedArgs
            );
        }

        $this->Paginator->settings = [
            'conditions' => $options,
            'order' => ['Pallet.print_date' => 'DESC'],
            'contain' => [
                'Location',
                'Item',
                'Shipment',
                'InventoryStatus'
            ]
        ];

        $this->set('pallets', $this->Paginator->paginate());

        $statuses = $this->Pallet->InventoryStatus->find('list');

        $locations = $this->Pallet->Location->find(
            'list',
            [
                'order' => [
                    'Location.location' => 'ASC'
                ],
                'recursive' => -1
            ]
        );

        $options = [
            'fields' => [
                'Shipment.id',
                "Shipment.shipper"
            ],
            'order' =>
            [
                'Shipment.shipper' => 'DESC'
            ]
        ];

        $shipments = $this->Pallet->Shipment->find('list', $options);

        $this->set(compact('locations', 'shipments', 'statuses'));
    }

    /*
     * query and return sscc
     */

    /**
     * Was going to be a scanning action not used I think
     *
     * @param string $sscc SSCC Number
     * @return void
     */
    public function sscc($sscc = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $sscc = $this->request->data['Pallet']['sscc_scan'];
        }

        if (!empty($sscc)) {
            if (strlen($sscc) != 18) {
                $sscc = substr($sscc, -18);
            }
            $options = [
                'conditions' => ['Pallet.sscc' => $sscc]
            ];
            $record = $this->Pallet->find('first', $options);
        }
        $this->set(compact('record'));
    }

    /**
     * @return mixed
     */
    public function search()
    {
        // the page we will redirect to
        $url['action'] = 'onhand';

        // build a URL will all the search elements in it
        // the resulting URL will be
        // example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
        foreach ($this->request->data as $k => $v) {
            foreach ($v as $kk => $vv) {
                $url[$k . '.' . $kk] = $vv;
            }
        }

        // redirect the user to the url

        return $this->redirect($url, null, true);
    }

    /**
     * Shows onhand stock and adds flags such as oncooldown,
     * pallet age, dont_ship etc
     *
     * @return void
     */
    public function onhand()
    {
        //$this->Pallet->Behaviors->load('Containable');

        $cooldown = $this->getSetting('cooldown');

        $this->Pallet->virtualFields['oncooldown'] = 'TIMESTAMPDIFF(HOUR, Pallet.cooldown_date, NOW()) < ' . $cooldown;
        $this->Pallet->virtualFields['pl_age'] = 'TIMESTAMPDIFF(HOUR, Pallet.print_date, NOW())';

        if (!empty($this->passedArgs['Pallet.filter_value'])) {
            $filter_value = $this->passedArgs['Pallet.filter_value'];
            //debug($this->passedArgs);
            $lookup_field = 'item_id';

            switch ($filter_value) {
                case 'low_dated':
                    $filter_value = 1;
                    $lookup_field = 'dont_ship';
                    break;
                case strpos($filter_value, 'product-type-') !== false:
                    $filter_value = str_replace('product-type-', '', $filter_value);
                    $lookup_field = 'product_type_id';
                    break;
                default:
                    $filter_value = $filter_value;
                    $lookup_field = 'item_id';
                    break;
            }

            // set the Search data, so the form remembers the option
            $this->request->data['Pallet']['filter_value'] = $this->passedArgs['Pallet.filter_value'];
        }

        $containSettings = [
            'Shipment' => [
                'fields' => [
                    'id', 'shipper'
                ]
            ],
            'InventoryStatus' => [
                'fields' => [
                    'id', 'name'
                ]
            ],
            'Item' => [
                'fields' => ['id', 'code', 'description']
            ],
            'Location' => [
                'fields' => ['id', 'location']
            ]
        ];

        $options = $this->Pallet->getViewOptions($containSettings);

        if (!empty($filter_value)) {
            $options['conditions']['Pallet.' . $lookup_field] = $filter_value;
        }

        $this->Paginator->settings = $options;

        $pallets = $this->Paginator->paginate('Pallet');

        $pallet_count = $this->Pallet->find('count', $options);

        $filter_values = $this->Pallet->getFilterValues();

        $dont_ship_count = $this->Pallet->getDontShipCount($pallets);

        $this->set(
            compact(
                'cooldown',
                'pallets',
                'pallet_count',
                'filter_values',
                'dont_ship_count'
            )
        );
    }

    /**
     * @param string $aisle Aisle to find columns and levels for
     *
     * @return void
     */
    public function columnsAndLevels($aisle = null)
    {
        list($aisles, $columns, $levels) = $this->Pallet->getColumnsAndLevels($aisle);

        $this->set(compact('columns', 'levels'));

        $this->render('/Elements/columns_levels');
    }

    /**
     * PutAway function
     *
     * @param ID $id ID of Pallet to put-away
     *
     * @return mixed
     */
    public function putAway($id = null)
    {
        if (!$this->Pallet->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        if ($this->request->is(['post', 'put'])) {
            $locationId = $this->request->data['Pallet']['location_id'];

            if ($this->Pallet->save($this->request->data)) {
                $location = $this->Pallet->Location->findById($locationId);

                $this->Flash->success(
                    __(
                        'The product has been saved to <strong>%s</strong>',
                        $location['Location']['location']
                    )
                );

                return $this->redirect(['action' => 'unassignedPallets']);
            } else {
                $error = '';
                foreach ($this->Pallet->validationErrors as $validationError) {
                    foreach ($validationError as $errorMessage) {
                        $error .= $errorMessage . ' ';
                    }
                }
                $this->Flash->error($error);
            }

            return $this->redirect(['action' => 'unassignedPallets']);
        } else {
            $options = [
                'contain' => [
                    'Item'
                ],
                'conditions' => [
                    'Pallet.' . $this->Pallet->primaryKey => $id
                ]
            ];

            $pallet = $this->Pallet->find('first', $options);

            $availableLocations = $this->Pallet->getAvailableLocations(
                $filter = 'available',
                $pallet['Item']['product_type_id']
            );
            $this->request->data = $pallet;

            $this->set(compact('availableLocations'));
        }
    }

    /**
     * unassignedPallets gets list of pallets that haven't been put-away yet
     *
     * @return void
     */
    public function unassignedPallets()
    {
        $this->Pallet->recursive = -1;
        $last_pallet = null;
        $pallets = null;
        $options = [
            'conditions' => [
                'Pallet.location_id' => 0,
                'Pallet.shipment_id' => 0
            ]
        ];

        //$this->Pallet->Behaviors->load("Containable");

        $productType = $this->Pallet->Item->ProductType->find(
            'all',
            [
                'conditions' => [
                    'ProductType.active' => 1,
                    'ProductType.location_id IS NULL'
                ],
                'contain' => true
            ]
        );

        $productTypeIds = Hash::extract($productType, '{n}.ProductType.id');

        if (!empty($productTypeIds)) {
            $last_pallet = $this->Pallet->find(
                'first',
                [
                    'order' => ['Pallet.id' => "DESC"],
                    'conditions' => [
                        'Pallet.location_id !=' => 0,
                        'Pallet.shipment_id' => 0,
                        'Pallet.product_type_id IN' => $productTypeIds
                    ],
                    'contain' => [
                        'Location'
                    ]
                ]
            );
        }

        $this->paginate = $options;

        $pallets = $this->Paginator->paginate();

        if (empty($pallets) && isset($last_pallet['Location']['location'])) {
            $this->Flash->success(
                __(
                    'The last product was saved to <strong>%s</strong>. There are no pallets to put away',
                    $last_pallet['Location']['location']
                ),
                [
                    'clear' => true
                ]
            );
        }

        $this->set(compact('pallets', 'last_pallet'));
    }

    /**
     * selectPalletPrintType returns list of product types to select page
     *
     * @return void
     */
    public function selectPalletPrintType()
    {
        $productTypes = $this->Pallet->Item->ProductType->find('list', [
            'conditions' => [
                'ProductType.active' => 1
            ]
        ]);
        $this->set(compact('productTypes'));
    }

    /**
     * Print a new pallet label
     *
     * @param int ProductTypeId $productTypeId Product Type ID
     *
     * @return mixed
     */
    public function palletPrint($productTypeId = null)
    {
        if (!$this->Pallet->ProductType->exists($productTypeId)) {
            throw new MissingConfigurationException(__('Invalid product type'));
        }

        $isPrintDebugMode = Configure::read('pallet_print_debug');

        $productType = $this->Pallet->Item
            ->ProductType->find(
                'first',
                [
                    'conditions' => [
                        'ProductType.id' => $productTypeId
                    ]
                ]
            );

        $locationId = $productType['ProductType']['location_id'];

        $productionLines = $this->Pallet->Item
            ->ProductType->ProductionLine->find(
                'list',
                [
                    'conditions' => [
                        'ProductionLine.product_type_id' => $productTypeId
                    ]
                ]
            );

        $inventoryStatusId = ($productType['ProductType']['inventory_status_id'] > 0)
            ? $productType['ProductType']['inventory_status_id'] : 0;

        if ($this->request->is('post')) {
            $plRefMaxLength = $this->Pallet->getSetting('plRefMaxLength');

            $str = 'Maximum length for a pallet reference is <strong>%d</strong>';
            $str .= ' characters. Please check the Product Type ';
            $str .= '"Serial number format"';
            $ruleMsg = sprintf($str, $plRefMaxLength);

            $this->Pallet->validator()->getField('pl_ref')
                ->setRules(
                    [
                        'notTooLong' => [
                            'rule' => ['maxLength', $plRefMaxLength],
                            'message' => $ruleMsg
                        ]
                    ]
                );

            $formName = array_key_exists(
                "PalletLabelLeftPalletPrintForm",
                $this->request->data
            ) ? "PalletLabelLeftPalletPrintForm" : "PalletLabelRightPalletPrintForm";

            $model = ClassRegistry::init(
                [
                    'class' => $formName,
                    'table' => false,
                    'type' => 'Model'
                ]
            );

            $model->validate = [
                'batch_no' => [
                    'notBlank' => [
                        'rule' => 'notBlank',
                        'required' => true,
                        'message' => 'Please select a batch'
                    ], 'notInvalid' => [
                        'rule' => ['checkBatchNum'],
                        'message' => 'Select a batch number allocated to today'
                    ]
                ],
                'item' => [
                    'rule' => 'notBlank',
                    'required' => true,
                    'message' => "Item cannot be empty"
                ],
                'production_line' => [
                    'rule' => 'notBlank',
                    'required' => true,
                    'message' => "Production line is required"
                ]
            ];

            $model->set($this->request->data);

            if ($model->validates()) {
                $productionLineId = $this->request
                    ->data[$formName]['production_line'];

                $productionLine = $this->Pallet->Item
                    ->ProductType->ProductionLine->find(
                        'first',
                        [
                            'conditions' => [
                                'ProductionLine.id' => $productionLineId
                            ]
                        ]
                    );

                $productionLineName = $productionLine['ProductionLine']['name'];

                $printerId = $productionLine['ProductionLine']['printer_id'];

                $printer = $this->Pallet->Printer->findById($printerId);

                if (!$printer) {
                    throw new MissingItemException(
                        [
                            'message' => "Missing Printer",
                            'printer' => $printerId
                        ],
                        404
                    );
                }

                $sscc = $this->Pallet->generateSSCCWithCheckDigit();

                $pallet_ref = $this->Pallet->createPalletRef($productTypeId);

                $item_detail = $this->Pallet->Item->find(
                    'first',
                    [
                        'conditions' => [
                            'Item.id' => $this->request->data[$formName]['item']
                        ],
                        'recursive' => -1
                    ]
                );

                $labelCopies = $item_detail['Item']['pallet_label_copies'] > 0
                    ? $item_detail['Item']['pallet_label_copies']
                    : $this->getSetting('sscc_default_label_copies');

                $printTemplateId = $item_detail['Item']['print_template_id'];

                $qty = !empty($this->request->data[$formName]['qty'])
                    ? $this->request->data[$formName]['qty']
                    : $item_detail['Item']['quantity'];

                $days_life = $item_detail['Item']['days_life'];

                $print_date = $this->Pallet->getDateTimeStamp();

                $print_date_plus_days_life = strtotime(
                    $print_date . ' + ' . $days_life . ' days'
                );

                $dateFormats = [
                    'bb_date' => 'Y-m-d',
                    'bb_bc' => 'ymd',
                    'bb_hr' => 'd/m/y'
                ];

                $bestBeforeDates = $this->Pallet->formatLabelDates(
                    $print_date_plus_days_life,
                    $dateFormats
                );

                // if the product_type has a default save location defined
                // set location_id else return 0
                $location_id = $locationId > 0
                    ? $locationId
                    : 0;

                $newLabel = [
                    'Pallet' => [
                        'item' => $item_detail['Item']['code'],
                        'description' => $item_detail['Item']['description'],
                        'bb_date' => $bestBeforeDates['bb_date'],
                        'item_id' => $this->request->data[$formName]['item'],
                        'batch' => $this->request->data[$formName]['batch_no'],
                        'qty' => $qty,
                        'qty_previous' => 0,
                        'pl_ref' => $pallet_ref,
                        'gtin14' => $item_detail['Item']['trade_unit'],
                        'sscc' => $sscc,
                        'printer' => $printer['Printer']['name'],
                        'printer_id' => $printerId,
                        'print_date' => $print_date,
                        'cooldown_date' => $print_date,
                        'location_id' => $location_id,
                        'shipment_id' => 0,
                        'inventory_status_id' => $inventoryStatusId,
                        'production_line' => $productionLineName,
                        'production_line_id' => $productionLineId,
                        'product_type_id' => $productType['ProductType']['id']
                    ]
                ];

                // the print template contents which has the replace tokens in it

                $print_template = $this->Pallet->Item->PrintTemplate->find(
                    'first',
                    [
                        'conditions' => [
                            'PrintTemplate.id' => $printTemplateId
                        ],
                        'recursive' => -1
                    ]
                );

                if (empty($print_template)) {
                    throw new MissingConfigurationException(
                        [
                            'message' => __(
                                'Print Template Missing: Check the <strong>"Pallet Label Print Template"</strong> setting of item <a href="%s">%s</a>',
                                Router::url(
                                    [
                                        'controller' => "Items",
                                        'action' => 'edit',
                                        $item_detail['Item']['id']
                                    ]
                                ),
                                $item_detail['Item']['code']
                            )],
                        '500'
                    );
                }

                $template_contents = $print_template['PrintTemplate']['text_template'];

                if (empty($template_contents)) {
                    throw new MissingConfigurationException('Template Contents Empty');
                }

                $replaceTokens = json_decode(
                    $this->getSetting(
                        'cabLabelTokens',
                        true
                    )
                );

                $cabLabel = new CabLabel(
                    [
                        'companyName' => Configure::read('companyName'),
                        'internalProductCode' => $item_detail['Item']['code'],
                        'reference' => $pallet_ref,
                        'sscc' => $sscc,
                        'description' => $item_detail['Item']['description'],
                        'gtin14' => $item_detail['Item']['trade_unit'],
                        'quantity' => $qty,
                        'bestBeforeHr' => $bestBeforeDates['bb_hr'],
                        'bestBeforeBc' => $bestBeforeDates['bb_bc'],
                        'batch' => $this->request->data[$formName]['batch_no'],
                        'numLabels' => $labelCopies
                    ],
                    $template_contents,
                    $replaceTokens
                );

                $return_value = $this->PrintLogic->sendPrint(
                    $cabLabel->printContent,
                    $this->PrintLogic->getPrintSettings(
                        $productionLine['Printer']['queue_name'],
                        $this->PrintLogic->getPrintJobName($pallet_ref),
                        $productionLine['Printer']['options'],
                        $productType['ProductType']['name']// tmp file prefix
                    )
                );

                if ($isPrintDebugMode || $return_value['return_value'] === 0) {
                    $this->Pallet->create();

                    if ($this->Pallet->save($newLabel)) {
                        $msg = $this->Pallet->createSuccessMessage(
                            $pallet_ref,
                            $return_value,
                            $productionLine['Printer']['name'],
                            $isPrintDebugMode
                        );

                        $func = $msg['type'];
                        $this->Flash->$func($msg['msg']);

                        return $this->redirect(
                            [
                                'action' => 'palletPrint',
                                $productTypeId
                            ]
                        );
                    } else {
                        $msg = __('The label data could not be saved. Please contact IT Support.');
                        // In a model class

                        if ($this->Pallet->validationErrors) {
                            $msg .= ' ' . $this->Pallet->formatValidationErrors(
                                $this->Pallet->validationErrors
                            );
                        }
                        $this->Flash->error($msg);
                    }
                } else {
                    $this->Flash->error(
                        __(
                            '<strong>Error: </strong>%s <strong>Command: </strong> %s',
                            h($return_value['stderr']),
                            h($return_value['cmd'])
                        )
                    );
                }
            } else {
                $this->Flash->error(__('Missing data. Please re-try.'));
            }
        }
        // populate form
        $batch_nos = $this->Pallet->getBatchNumbers();

        //$defaultLines = $printTypes[$print_type]['defaults'];

        $product_type = $productType['ProductType']['name'];

        $items = $this->Pallet->Item->getPalletPrintItems($productTypeId);

        $this->set(
            compact(
                'items',
                'productionLines',
                'batch_nos',
                'product_type'
            )
        );
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id ID of Pallet
     * @return mixed
     */
    public function reprint($id = null)
    {
        $this->Pallet->recursive = -1;

        if (!$this->Pallet->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        $options = [
            'conditions' => ['Pallet.' . $this->Pallet->primaryKey => $id],
            'contain' => [
                'Item' => [
                    "ProductType",
                    "PrintTemplate"
                ]
            ]];

        $pallet = $this->Pallet->find('first', $options);

        $this->Pallet->validator()->add('printer_id', 'required', [
            'rule' => 'notBlank',
            'message' => 'Please select a printer'
        ]);

        if ($this->request->is(['post', 'put'])) {
            //$this->Pallet->Behaviors->load("Containable");

            // handle print post

            $pallet_ref = $pallet['Pallet']['pl_ref'];

            $replaceTokens = json_decode(
                $this->getSetting(
                    'cabLabelTokens',
                    true
                )
            );

            if (!isset($pallet['Item']['PrintTemplate']) || empty($pallet['Item']['PrintTemplate'])) {
                throw new MissingConfigurationException(__('Please configure a print template for item %s', $pallet['Pallet']['item']));
            }

            $template_contents = $pallet['Item']['PrintTemplate']['text_template'];

            $cabLabel = new CabLabel(
                [
                    'companyName' => Configure::read('companyName'),
                    'internalProductCode' => $pallet['Item']['code'],
                    'reference' => $pallet['Pallet']['pl_ref'],
                    'sscc' => $pallet['Pallet']['sscc'],
                    'description' => $pallet['Item']['description'],
                    'gtin14' => $pallet['Pallet']['gtin14'],
                    'quantity' => $pallet['Pallet']['qty'],
                    'bestBeforeHr' => $pallet['Pallet']['best_before'],
                    'bestBeforeBc' => $this->formatYymmdd($pallet['Pallet']['bb_date']),
                    'batch' => $pallet['Pallet']['batch'],
                    'numLabels' => $this->request->data['Pallet']['copies']
                ],
                $template_contents,
                $replaceTokens
            );

            $itemId = $pallet['Pallet']['item_id'];

            // get the printer queue name
            $printerId = $this->request->data['Pallet']['printer_id'];

            $printer_details = $this->Pallet->getLabelPrinterById($printerId);

            $print_job = $this->PrintLogic->getPrintJobName(
                $pallet['Pallet']['pl_ref'],
                true
            );

            $print_settings = $this->PrintLogic->getPrintSettings(
                $printer_details['Printer']['queue_name'],
                $print_job,
                $printer_details['Printer']['options'],
                $pallet['Item']['ProductType']['name']
            );

            $inDebugMode = Configure::read('pallet_print_debug');

            $return_value = $this->PrintLogic->sendPrint(
                $cabLabel->printContent,
                $print_settings
            );

            if ($inDebugMode || $return_value['return_value'] === 0) {
                $msg = $this->Pallet->createSuccessMessage(
                    $pallet_ref,
                    $return_value,
                    $printer_details['Printer']['name'],
                    $inDebugMode
                );

                $func = $msg['type'];

                $this->Flash->$func($msg['msg']);

                return $this->redirect($this->request->data['Pallet']['refer']);
            } else {
                $this->Flash->error(
                    __(
                        '<strong>Error: </strong> %s <strong>Command: </strong> %s',
                        h($return_value['stderr']),
                        h($return_value['cmd'])
                    )
                );
            }
        }

        $printers = $this->Pallet->getLabelPrinters(
            $this->request->controller,
            $this->request->action
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers
        unset($pallet['Pallet']['printer_id']);
        $labelCopies = $pallet['Item']['pallet_label_copies'] > 0
            ? $pallet['Item']['pallet_label_copies']
            : $this->getSetting('sscc_default_label_copies');
        $tag = "Pallet";
        $labelCopiesList = [];
        for ($i = 1; $i <= $labelCopies; $i++) {
            if ($i > 1) {
                $tag = Inflector::pluralize($tag);
            } else {
                $tag = Inflector::singularize($tag);
            }
            $labelCopiesList[$i] = $i . " " . $tag;
        }

        $this->request->data = $pallet;

        $refer = $this->referer();
        $inputDefaultCopies = $this->getSetting('sscc_default_label_copies');
        $this->set(
            compact(
                'labelCopiesList',
                'pallet',
                'printers',
                'refer',
                'inputDefaultCopies'
            )
        );
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id Pallet ID
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Pallet->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }
        $options = ['conditions' => ['Pallet.' . $this->Pallet->primaryKey => $id]];

        $this->set('pallet', $this->Pallet->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Pallet->create();
            if ($this->Pallet->save($this->request->data)) {
                $this->Flash->set(__('The label has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->set(__('The label could not be saved. Please, try again.'));
            }
        }
        $locations = $this->Pallet->Location->find('list');
        $shipments = $this->Pallet->Shipment->find('list');
        $this->set(compact('locations', 'shipments'));
    }

    /**
     * @param ID $id ID of Pallet
     * @return mixed
     */
    public function changeLocation($id = null)
    {
        if (!$this->Pallet->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Pallet->save($this->request->data)) {
                $this->Flash->set(__('The label has been saved.'));

                return $this->redirect(['action' => 'onhand']);
            } else {
                $this->Flash->set(__('The label could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Pallet.' . $this->Pallet->primaryKey => $id]];
            $this->request->data = $this->Pallet->find('first', $options);
        }
        $locations = $this->Pallet->Location->find('list');
        $shipments = $this->Pallet->Shipment->find('list');
        $this->set(compact('locations', 'shipments'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id ID of pallet
     * @return void
     */
    public function multiEdit($id = null)
    {
        $this->layout = 'ajax';
        $this->render(false);

        if ($this->request->is(['post', 'put'])) {
            $origin = $this->request->header('Origin');
            $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
            if (in_array($origin, $allowedOrigins)) {
                $this->response->header('Access-Control-Allow-Origin', $origin);
            }
            if ($this->Pallet->saveMany($this->request->data)) {
                if ($this->request->is('ajax')) {
                    $this->autoRender = false;
                    $this->response->type = 'json';
                    $msg = [
                        'result' => 'success',
                        'message' => 'Successfully updated pallet'
                    ];
                    $this->response->body(json_encode($msg));

                    return;
                }
                $this->Flash->set(__('The label has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->autoRender = false;
                $this->response->type = 'json';
                $msg = [
                    'result' => 'danger',
                    'message' => 'The data could not be saved'
                ];
                $this->response->body(json_encode($msg));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id ID
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Pallet->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }

        if ($this->request->is(['post', 'put'])) {
            if ($this->Pallet->save($this->request->data)) {
                if ($this->request->is('ajax')) {
                    $this->autoRender = false;
                    $this->response->type = 'json';
                    $msg = [
                        'result' => 'success',
                        'message' => 'Successfully updated label'
                    ];
                    $this->response->body(json_encode($msg));

                    return;
                }
                $this->Flash->set(__('The label has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->set(__('The label could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Pallet.' . $this->Pallet->primaryKey => $id]];
            $this->request->data = $this->Pallet->find('first', $options);
        }
        $locations = $this->Pallet->Location->find('list');
        $shipments = $this->Pallet->Shipment->find('list');

        $this->set(compact('locations', 'shipments'));
        $this->set('_serialize', ['locations', 'shipments']);
    }

    /**
     * @param int $id Supply ID of pallet
     * @return mixed
     */
    public function editPallet($id = null)
    {
        if (!$this->Pallet->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Pallet->save($this->request->data)) {
                $this->Flash->success(__('The pallet data has been saved.'));

                return $this->redirect($this->request->data['Pallet']['referer']);
            } else {
                $this->Flash->error(__('The  pallet data could not be saved. Please, try again.'));
            }
        }
        $options = ['conditions' => ['Pallet.' . $this->Pallet->primaryKey => $id]];
        $label_info = $this->Pallet->find('first', $options);
        $label_info['Pallet']['qty_before'] = $label_info['Pallet']['qty'];

        $this->request->data = $label_info;

        $item_data = $this->Pallet->Item->find('first', [
            'conditions' => [
                'Item.id' => $label_info['Pallet']['item_id']
            ],
            'contain' => true
        ]);

        $item_qty = $item_data['Item']['quantity'];
        $inventory_statuses = $this->Pallet->InventoryStatus->find('list');

        $productType = $this->Pallet->getProductType($id);
        $productTypeId = isset($productType['ProductType']['id'])
            ? $productType['ProductType']['id'] : 0;

        $availableLocations = $this->Pallet->getAvailableLocations('available', $productTypeId);

        $currentLocation = [
            $label_info['Location']['id'] =>
            $label_info['Location']['location']
        ];

        $locationsCombined = $availableLocations + $currentLocation;
        asort($locationsCombined, SORT_NATURAL);
        $locations = $locationsCombined;

        $shipments = $this->Pallet->Shipment->find('list');

        $this->request->data['Pallet']['qty_user_id'] = $this->Auth->user()['id'];
        $this->request->data['Pallet']['product_type_id'] = $item_data['ProductType']['id'];

        $this->request->data['Pallet']['referer'] = $this->referer();
        $restricted = $this->isAuthorized($this->Auth->user()) ? false : true;

        $this->set(
            compact(
                'item_qty',
                'locations',
                'shipments',
                'inventory_statuses',
                'restricted'
            )
        );
    }

    /**
     * move pallet to new location
     *
     * @param int $id ID of Pallet
     * @return mixed
     */
    public function move($id = null)
    {
        if (!$this->Pallet->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        if ($this->request->is(['post', 'put'])) {
            $location_find = $this->Pallet->Location->find(
                'first',
                [
                    'conditions' => [
                        'Location.id' => $this->request->data['Pallet']['location_id']
                    ],
                    'recursive' => -1
                ]
            );

            $msg = sprintf(
                'Pallet moved from <strong>%s</strong> to <strong>%s</strong>',
                $this->request->data['Pallet']['previous_location'],
                $location_find['Location']['location']
            );

            // store the value the field was before changed

            if ($this->Pallet->save($this->request->data)) {
                $this->Flash->success($msg);

                return $this->redirect($this->request->data['Pallet']['referer']);
            } else {
                $this->Flash->error(__('The label could not be saved. Please, try again.'));
            }
        }
        $options = [
            'contain' => ['Location'],
            'conditions' => ['Pallet.' . $this->Pallet->primaryKey => $id]];
        $label_info = $this->Pallet->find('first', $options);

        $this->request->data = $label_info;
        $this->request->data['Pallet']['previous_location_id']
        = $label_info['Pallet']['location_id'];

        $locations = $this->Pallet->Location->find(
            'list',
            [
                'conditions' => [
                    'Location.' . $this->Pallet->Location->primaryKey =>
                    $label_info['Pallet']['location_id']
                ],
                'order' => [
                    'Location.location' => 'ASC'
                ]
            ]
        );

        $this->request->data['Pallet']['previous_location'] = $locations[$label_info['Pallet']['location_id']];

        $shipments = $this->Pallet->Shipment->find('list');
        $this->request->data['Pallet']['referer'] = $this->referer();

        $restricted = true;

        $productType = $this->Pallet->getProductType($id);
        $productTypeId = isset($productType['ProductType']['id'])
            ? $productType['ProductType']['id'] : 0;

        $availableLocations = $this->Pallet->getAvailableLocations('available', $productTypeId);

        $this->set(compact('locations', 'availableLocations'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id Delete a Pallet
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        // bug out on redirect to referer from auth component
        if ($this->request->is('get')) {
            return $this->redirect(['action' => 'index']);
        }
        $this->Pallet->id = $id;
        if (!$this->Pallet->exists()) {
            throw new NotFoundException(__('Invalid label'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Pallet->delete()) {
            $this->Flash->success(__('The label has been deleted.'));
        } else {
            $this->Flash->error(__('The label could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * locationStockLevels method
     *
     * @param mixed $filter Filter value default is all but can be
     *
     * @return void
     */
    public function locationSpaceUsage($filter = 'all')
    {
        $viewOptions = [
            'limit' => 800,
            'maxLimit' => 3000
        ];
        $options = $this->Pallet->locationSpaceUsageOptions($filter, 'all', $viewOptions);
        $this->paginate = $options;

        $locations = $this->Paginator->paginate();

        $this->set(compact('locations', 'filter'));
    }
}