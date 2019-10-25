<?php

App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
App::import('Vendor', 'CabLabel');
App::uses('MissingItemException', 'Lib');

/**
 * Labels Controller
 *
 * @property Label $Label
 * @property PaginatorComponent $Paginator
 * @property PrintLogicComponent $PrintLogic
 */
class LabelsController extends AppController
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

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('palletReferenceLookup');
        $this->Auth->deny(['editPallet', 'bulkStatusRemove', 'delete']);
    }

    /**
     * @param $url_date
     */
    public function formatReport($url_date = null)
    {

        $this->loadModel('Shift');

        if ($this->request->is('POST')) {

            if (!empty($this->request->data['Label']['start_date'])) {
                $query_date = $this->request->data['Label']['start_date'];
            } elseif (!empty($this->request->data['Label']['report_date'])) {
                $query_date = $this->request->data['Label']['report_date'];
            }

            if (!empty($url_date)) {
                $query_date = $url_date;
            }

            $reports = $this->Label->enumShifts($query_date);

            $this->set('reports', $reports['reports']);
            $this->set('shift_date', $this->Label->arrayToMysqlDate($query_date));
            $this->set('xml_shift_report', $reports['xml_shift_report']);
        }

        $shifts = $this->Shift->find('list', [
            'conditions' => [
                'Shift.active' => 1,
                'Shift.for_prod_dt' => 0
            ]
        ]);
        if (isset($params)) {
            $this->set('params', $params);
        }
        $this->set('shifts', $shifts);
        $this->set("_serialize", ['xml_shift_report']);

    }

    /**
     * @param $passed
     */
    public function filterStatus($passed)
    {

        if (isset($passed['inventory_status_id'])) {
            if ($passed['inventory_status_id'] !== '') {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @param $status_id
     */
    public function bulkStatusRemove($status_id = null)
    {

        $view_perms = $this->Label->getViewPermNumber('view_in_remove_status');

        if ($this->request->is(["POST", 'PUT']) && !empty($this->request->data['Label'])) {

            $inventory_status_note = $this->Label->inventoryStatusNote($this->request->data['Label']);

            $update_statuses = [];
            foreach ($this->request->data['Label'] as $label) {

                if (isset($label['inventory_status_id'])) {

                    //if(!empty($inventory_status_note)){
                    $label['inventory_status_note'] = $inventory_status_note;
                    //}

                    $update_statuses[] = $label;

                }
            }

            if (!empty($update_statuses)) {

                if ($this->Label->saveMany(
                    $update_statuses, ['validate' => false]
                )) {
                    $this->Flash->success(__('The data has been saved.'));
                    $this->request->data['Label']['inventory_status_note_global'] = "";
                };
            }

        }

        $this->Label->recursive = 0;
        $this->Paginator->settings = [
            'order' => [
                'Label.id' => 'DESC'
            ],
            'limit' => 500,
            'maxLimit' => 3000
        ];

        if ($status_id === null) {
            $this->Paginator->settings['conditions'] = [
                'Label.shipment_id' => 0
            ];
        } else {
            $this->Paginator->settings['conditions'] = [
                'Label.inventory_status_id' => $status_id,
                'Label.shipment_id' => 0,
                'InventoryStatus.perms & ' . $view_perms
            ];
        }

        $labels = $this->Paginator->paginate();
        $status_options = [
            'recursive' => -1,
            'conditions' => [
                'InventoryStatus.perms & ' . $view_perms
            ]
        ];

        $statuses = $this->Label->InventoryStatus->find('all', $status_options);
        $status_list = $this->Label->InventoryStatus->find('list', $status_options);

        $status_list[0] = 'No Status';
        unset($status_list[$status_id]);

        ksort($status_list);

        // debug($labels);
        $disable_footer = true;
        $this->set(compact('labels', 'statuses', 'status_id', 'status_list', 'disable_footer'));
    }

    /**
     * @param $user
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

    public function updateMinDaysLife()
    {
        $this->Label->recursive = -1;

        $this->Label->Behaviors->load('Containable');

        $global_life = $this->Label->getGlobalMinDaysLife();

        $shipments = $this->Label->find('all', [
            'contain' => 'Item',
            'conditions' => [
                'Label.min_days_life' => 0
            ]
        ]);

        foreach ($shipments as $shipment) {
            $item = $shipment['Item']['min_days_life'];

            $shipment['Label']['min_days_life'] = (bool)$item ? $item : $global_life;
            $pl_ref = $shipment['Label']['pl_ref'];

            unset($shipment['Item']);

            $save_this = [
                'id' => $shipment['Label']['id'],
                'modified' => false,
                'min_days_life' => (bool)$item ? $item : $global_life
            ];

            if ($this->Label->save($save_this)) {
                // ok
                echo "Updating " . $pl_ref . "\n";
            }
        }

        $this->autoRender = false;
        //$this->Shipment->save($this->request->data)
    }

    public function batch_lookup()
    {
        $search_term = $this->request->query['term'];

        $json_output = $this->Label->batchLookup($search_term);

        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    public function palletReferenceLookup()
    {
        $search_term = $this->request->query['term'];
        $json_output = $this->Label->palletReferenceLookup($search_term);
        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    public function item_lookup()
    {
        $search_term = $this->request->query['term'];

        $json_output = $this->Label->Item->item_lookup($search_term);

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
        $this->Label->recursive = 0;
        $this->Paginator->settings = [
            'order' => [
                'Label.id' => 'DESC'
            ],
            'limit' => 500
        ];
        $this->set('labels', $this->Paginator->paginate());
    }

    /**
     * @return mixed
     */
    public function lookup_search()
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

    public function lookup()
    {
        $options = [];

        if (!empty($this->passedArgs)) {
            $options = $this->Label->formatLookupActionConditions($this->passedArgs);
            $this->request->data = $this->Label->formatLookupRequestData($this->passedArgs);
        }

        $this->Paginator->settings = [
            'conditions' => $options,
            'contain' => [
                'Location',
                'Item',
                'Shipment',
                'InventoryStatus'
            ]
        ];

        $this->set('labels', $this->Paginator->paginate());

        $statuses = $this->Label->InventoryStatus->find('list');

        $locations = $this->Label->Location->find('list', [
            'order' => [
                'Location.location' => 'ASC'
            ],
            'recursive' => -1
        ]);

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

        $shipments = $this->Label->Shipment->find('list', $options);

        $this->set(compact('locations', 'shipments', 'statuses'));
    }

    /*
     * query and return sscc
     */

    /**
     * @param $sscc
     */
    public function sscc($sscc = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $sscc = $this->request->data['Label']['sscc_scan'];

            # we want the right most 18 digits (strips 00 AI)
        }

        if (!empty($sscc)) {
            if (strlen($sscc) != 18) {
                $sscc = substr($sscc, -18);
            }
            $options = [
                'conditions' => ['Label.sscc' => $sscc]
            ];
            $record = $this->Label->find('first', $options);
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

    public function onhand()
    {
        $this->Label->Behaviors->load('Containable');

        $cooldown = $this->getSetting('cooldown');

        $this->Label->virtualFields['oncooldown'] = 'TIMESTAMPDIFF(HOUR, Label.cooldown_date, NOW()) < ' . $cooldown;
        $this->Label->virtualFields['pl_age'] = 'TIMESTAMPDIFF(HOUR, Label.print_date, NOW())';

        if (!empty($this->passedArgs['Label.filter_value'])) {
            $filter_value = $this->passedArgs['Label.filter_value'];
            //debug($this->passedArgs);
            $lookup_field = 'item_id';
            $operator = 'LIKE';
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
                    $operator = '';
                    break;
            }

            // set the Search data, so the form remembers the option
            $this->request->data['Label']['filter_value'] = $this->passedArgs['Label.filter_value'];
        }

        $options = $this->Label->getViewOptions(
            [
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
            ]
        );

        if (!empty($filter_value)) {
            $options['conditions'][
                'Label.' . $lookup_field . ' ' . $operator
            ] = $filter_value;
        }

        $this->Paginator->settings = $options;

        $labels = $this->Paginator->paginate('Label');

        $label_count = $this->Label->find('count', $options);

        $filter_values = $this->Label->getFilterValues();

        $dont_ship_count = $this->Label->getDontShipCount($labels);

        $this->set(
            compact(
                'cooldown',
                'labels',
                'label_count',
                'filter_values',
                'dont_ship_count'
            )
        );
    }

    /**
     * @param $aisle
     */
    public function columns_and_levels($aisle = null)
    {

        list($aisles, $columns, $levels) = $this->Label->getColumnsAndLevels($aisle);

        $this->set(compact('columns', 'levels'));

        $this->render('/Elements/columns_levels');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function put_away($id = null)
    {
        if (!$this->Label->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        if ($this->request->is(['post', 'put'])) {

            $locationId = $this->request->data['Label']['location_id'];

            if ($this->Label->save($this->request->data)) {
                $location = $this->Label->Location->findById($locationId);

                $this->Flash->success(
                    __(
                        'The product has been saved to <strong>%s</strong>',
                        $location['Location']['location']
                    )
                );
                return $this->redirect(['action' => 'unassigned_pallets']);
            } else {
                $error = '';
                foreach ($this->Label->validationErrors as $validationError) {
                    foreach ($validationError as $errorMessage) {
                        $error .= $errorMessage . ' ';
                    }
                }
                $this->Flash->error($error);
            }

            return $this->redirect(['action' => 'unassigned_pallets']);

        } else {
            $options = [
                'contain' => [
                    'Item'
                ],
                'conditions' => [
                    'Label.' . $this->Label->primaryKey => $id
                ]
            ];

            $label = $this->Label->find('first', $options);

            $availableLocations = $this->Label->getAvailableLocations(
                $filter = 'available',
                $label['Item']['product_type_id']
            );
            $this->request->data = $label;

            $this->set(compact('availableLocations'));
        }

    }

    public function unassigned_pallets()
    {
        $this->Label->recursive = -1;
        $last_pallet = null;
        $labels = null;
        $options = [
            'conditions' => [
                'Label.location_id' => 0,
                'Label.shipment_id' => 0
            ]
        ];

        $this->Label->Behaviors->load("Containable");

        $productType = $this->Label->Item->ProductType->find(
            'all', [
                'conditions' => [
                    'ProductType.active' => 1,
                    'ProductType.location_id IS NULL'
                ],
                'contain' => true
            ],

        );

        $productTypeIds = Hash::extract($productType, '{n}.ProductType.id');

        if (!empty($productTypeIds)) {

            $last_pallet = $this->Label->find(
                'first', [
                    'order' => ['Label.id' => "DESC"],
                    'conditions' => [
                        'Label.location_id !=' => 0,
                        'Label.shipment_id' => 0,
                        'Label.product_type_id IN' => $productTypeIds
                    ],
                    'contain' => [
                        'Location'
                    ]
                ]
            );
        }

        $this->paginate = $options;

        $labels = $this->Paginator->paginate();

        if (empty($labels) && isset($last_pallet['Location']['location'])) {

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

        $this->set(compact('labels', 'last_pallet'));
    }

    public function selectPalletPrintType()
    {
        $productTypes = $this->Label->Item->ProductType->find('list', [
            'conditions' => [
                'ProductType.active' => 1
            ]
        ]);
        $this->set(compact('productTypes'));
    }
    /**
     * Print a new pallet label
     *
     * @param string $productTypeId Produc Type
     *
     * @return mixed
     */
    public function pallet_print($productTypeId = null)
    {

        if ($productTypeId === null ||
            !$this->Label->ProductType->exists($productTypeId)
        ) {
            throw new NotFoundException(__('Invalid product type'));
        }

        $isPrintDebugMode = Configure::read('pallet_print_debug');

        $productType = $this->Label->Item
            ->ProductType->find(
                'first', [
                    'conditions' => [
                        'ProductType.id' => $productTypeId
                    ]
                ]
            );

        $productionLines = $this->Label->Item
            ->ProductType->ProductionLine->find(
                'all', [
                    'conditions' => [
                        'ProductionLine.product_type_id' => $productTypeId
                    ]
                ]
            );

        $productionLineList = Hash::combine(
            $productionLines,
            '{n}.ProductionLine.id',
            '{n}.ProductionLine.name'
        );
        $inventoryStatusId = ($productType['ProductType']['inventory_status_id'] > 0)
            ? $productType['ProductType']['inventory_status_id'] : 0;

        if ($this->request->is('post')) {

            $plRefMaxLength = $this->Label->getSetting('plRefMaxLength');
            $str = 'Maximum length for a pallet reference is <strong>%d</strong>';
            $str .= ' characters. Please check the Product Type ';
            $str .= '"Serial number format"';
            $ruleMsg = sprintf($str, $plRefMaxLength);

            $this->Label->validator()->getField('pl_ref')
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

                $productionLine = $this->Label->Item
                    ->ProductType->ProductionLine->find(
                        'first', [
                            'conditions' => [
                                'ProductionLine.id' => $productionLineId
                            ]
                        ]
                    );

                $productionLineName = $productionLine['ProductionLine']['name'];

                $printerId = $productionLine['ProductionLine']['printer_id'];

                if (!$this->Label->Printer->exists($printerId)) {
                    throw new MissingItemException(
                        [
                            'message' => "Missing Printer",
                            'printer' => $printerId
                        ],
                        404
                    );
                }

                $sscc = $this->Label->generateSSCC();

                $sscc .= $this->Label->generateCheckDigit($sscc);

                $pallet_ref = $this->Label->createPalletRef($productTypeId);

                $item_detail = $this->Label->Item->find(
                    'first', [
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

                $print_date = $this->Label->getDateTimeStamp();

                $print_date_plus_days_life = strtotime(
                    $print_date . ' + ' . $days_life . ' days'
                );

                $bb_hr = $this->Label->formatLabelDates(
                    'd/m/y',
                    $print_date_plus_days_life
                );
                $bb_date = $this->Label->formatLabelDates(
                    'Y-m-d',
                    $print_date_plus_days_life
                );
                $bb_bc = $this->Label->formatLabelDates(
                    'ymd',
                    $print_date_plus_days_life
                );

                // if the print_type is oil return the "Bottling"
                // location id else return 0
                // bottling location id or marg default of 0
                if ($productType['ProductType']['location_id'] > 0) {
                    $location_id = $productType['ProductType']['location_id'];
                } else {
                    $location_id = 0;
                }

                $newLabel = [
                    'Label' => [
                        'item' => $item_detail['Item']['code'],
                        'description' => $item_detail['Item']['description'],
                        'bb_date' => $bb_date, // Y-m-d
                         'item_id' => $this->request->data[$formName]['item'],
                        'batch' => $this->request->data[$formName]['batch_no'],
                        'qty' => $qty,
                        'qty_previous' => 0,
                        'pl_ref' => $pallet_ref,
                        'gtin14' => $item_detail['Item']['trade_unit'],
                        'sscc' => $sscc,
                        'printer_id' => $printerId,
                        'print_date' => $print_date,
                        'cooldown_date' => $print_date,
                        'location_id' => $location_id, # default is zero or bottling location id
                         'shipment_id' => 0,
                        'inventory_status_id' => $inventoryStatusId,
                        'production_line' => $productionLineName,
                        'production_line_id' => $productionLineId,
                        'product_type_id' => $productType['ProductType']['id']
                    ]
                ];

                // the print template contents which has the replace tokens in it

                $print_template = $this->Label->Item->PrintTemplate->find(
                    'first', [
                        'conditions' => [
                            'PrintTemplate.id' => $printTemplateId
                        ],
                        'recursive' => -1
                    ]
                );

                if (empty($print_template)) {
                    $exceptionText = 'Print Template Missing. Check pallet label ';
                    $exceptionText .= ' template configuration of item %s';

                    throw new NotFoundException(
                        sprintf($exceptionText, $item_detail['Item']['code'])
                    );
                }

                $template_contents = $print_template['PrintTemplate']['text_template'];

                if (empty($template_contents)) {
                    throw new NotFoundException('Template Contents Empty');
                }

                $replaceTokens = json_decode(
                    $this->getSetting(
                        'cabLabelTokens', true
                    )
                );

                $cabLabel = new CabLabel(
                    [
                        'companyName' => $this->getSetting('companyName'),
                        'internalProductCode' => $item_detail['Item']['code'],
                        'reference' => $pallet_ref,
                        'sscc' => $sscc,
                        'description' => $item_detail['Item']['description'],
                        'gtin14' => $item_detail['Item']['trade_unit'],
                        'quantity' => $qty,
                        'bestBeforeHr' => $bb_hr,
                        'bestBeforeBc' => $bb_bc,
                        'batch' => $this->request->data[$formName]['batch_no'],
                        'numLabels' => $labelCopies
                    ],
                    $template_contents,
                    $replaceTokens
                );

                $print_job = $this->PrintLogic->getPrintJobName($pallet_ref, $reprint = false);

                $print_settings = $this->PrintLogic->getPrintSettings(
                    $productionLine['Printer']['queue_name'],
                    $print_job,
                    $productionLine['Printer']['options'],
                    $productType['ProductType']['name']// tmp file prefix
                );

                $return_value = $this->PrintLogic->sendPrint(
                    $cabLabel->printContent,
                    $print_settings
                );

                if ($isPrintDebugMode || $return_value['return_value'] === 0) {

                    $this->Label->create();

                    if ($this->Label->save($newLabel)) {

                        $msg = $this->Label->createSuccessMessage(
                            $pallet_ref,
                            $return_value,
                            $productionLine['Printer']['name'],
                            $isPrintDebugMode
                        );

                        $func = $msg['type'];
                        $this->Flash->$func($msg['msg']);

                        return $this->redirect(
                            [
                                'action' => 'pallet_print',
                                $productTypeId
                            ]
                        );
                    } else {
                        $msg = __('The label data could not be saved. Please contact IT Support.');
                        // In a model class

                        if ($this->Label->validationErrors) {
                            $msg .= ' ' . $this->Label->formatValidationErrors($this->Label->validationErrors);
                        }
                        $this->Flash->error($msg);
                    }
                } else {

                    $this->Flash->error(
                        '<strong>Error: </strong>' .
                        h($return_value['stderr']) .
                        ' <strong>Command: </strong> ' .
                        h($return_value['cmd'])
                    );
                }
            } else {
                $this->Flash->error(__('Missing data. Please re-try.'));
            }

        }
        // populate form
        $batch_nos = $this->Label->getBatchNumbers();

        //$defaultLines = $printTypes[$print_type]['defaults'];

        $product_type = $productType['ProductType']['name'];

        $items = $this->Label->Item->getPalletPrintItems($productTypeId);

        $this->set(
            compact(
                //'defaultLines',
                 'items',
                'productionLineList',
                'batch_nos',
                'product_type'
            )
        );
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return mixed
     */
    public function reprint($id = null)
    {

        $this->Label->recursive = -1;

        if (!$this->Label->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        $options = [
            'conditions' => ['Label.' . $this->Label->primaryKey => $id],
            'contain' => [
                'Item' => [
                    "ProductType",
                    "PrintTemplate"
                ]
            ]];

        $label = $this->Label->find('first', $options);

        if ($this->request->is(['post', 'put'])) {

            $this->Label->Behaviors->load("Containable");

            // handle print post

            $pallet_ref = $label['Label']['pl_ref'];

            $replaceTokens = json_decode(
                $this->getSetting(
                    'cabLabelTokens',
                    true
                )
            );

            $template_contents = $label['Item']['PrintTemplate']['text_template'];

            $cabLabel = new CabLabel(
                [
                    'companyName' => $this->getSetting('companyName'),
                    'internalProductCode' => $label['Item']['code'],
                    'reference' => $label['Label']['pl_ref'],
                    'sscc' => $label['Label']['sscc'],
                    'description' => $label['Item']['description'],
                    'gtin14' => $label['Label']['gtin14'],
                    'quantity' => $label['Label']['qty'],
                    'bestBeforeHr' => $label['Label']['best_before'],
                    'bestBeforeBc' => $this->formatYYMMDD($label['Label']['bb_date']),
                    'batch' => $label['Label']['batch'],
                    'numLabels' => $this->request->data['Label']['copies']
                ],
                $template_contents,
                $replaceTokens
            );

            $itemId = $label['Label']['item_id'];

            // get the printer queue name
            $printerId = $this->request->data['Label']['printer_id'];

            $printer_details = $this->Label->getLabelPrinterById($printerId);

            $print_job = $this->PrintLogic->getPrintJobName(
                $label['Label']['pl_ref'],
                true
            );

            $print_settings = $this->PrintLogic->getPrintSettings(
                $printer_details['Printer']['queue_name'],
                $print_job,
                $printer_details['Printer']['options'],
                $label['Item']['ProductType']['name']
            );

            $inDebugMode = Configure::read('pallet_print_debug');

            $return_value = $this->PrintLogic->sendPrint(
                $cabLabel->printContent,
                $print_settings
            );

            if ($inDebugMode || $return_value['return_value'] === 0) {

                $msg = $this->Label->createSuccessMessage(
                    $pallet_ref,
                    $return_value,
                    $printer_details['Printer']['name'],
                    $inDebugMode
                );

                $func = $msg['type'];

                $this->Flash->$func($msg['msg']);

                return $this->redirect($this->request->data['Label']['refer']);
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

        $printers = $this->Label->getLabelPrinters(
            $this->request->controller,
            $this->request->action
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers
        unset($label['Label']['printer_id']);
        $labelCopies = $label['Item']['pallet_label_copies'] > 0
            ? $label['Item']['pallet_label_copies']
            : $this->getSetting('sscc_default_label_copies');
        $tag = "Label";
        $labelCopiesList = [];
        for ($i = 1; $i <= $labelCopies; $i++) {
            if ($i > 1) {
                $tag = Inflector::pluralize($tag);
            } else {
                $tag = Inflector::singularize($tag);
            }
            $labelCopiesList[$i] = $i . " " . $tag;
        }

        $this->request->data = $label;

        $refer = $this->referer();
        $inputDefaultCopies = $this->getSetting('sscc_default_label_copies');
        $this->set(
            compact(
                'labelCopiesList',
                'label',
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
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Label->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }
        $options = ['conditions' => ['Label.' . $this->Label->primaryKey => $id]];

        $this->set('label', $this->Label->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Label->create();
            if ($this->Label->save($this->request->data)) {
                $this->Flash->set(__('The label has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->set(__('The label could not be saved. Please, try again.'));
            }
        }
        $locations = $this->Label->Location->find('list');
        $shipments = $this->Label->Shipment->find('list');
        $this->set(compact('locations', 'shipments'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function changeLocation($id = null)
    {
        if (!$this->Label->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Label->save($this->request->data)) {
                $this->Flash->set(__('The label has been saved.'));

                return $this->redirect(['action' => 'onhand']);
            } else {
                $this->Flash->set(__('The label could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Label.' . $this->Label->primaryKey => $id]];
            $this->request->data = $this->Label->find('first', $options);
        }
        $locations = $this->Label->Location->find('list');
        $shipments = $this->Label->Shipment->find('list');
        $this->set(compact('locations', 'shipments'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
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
            if ($this->Label->saveMany($this->request->data)) {
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
        if (!$this->Label->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        $origin = $this->request->header('Origin');
        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        if (in_array($origin, $allowedOrigins)) {
            $this->response->header('Access-Control-Allow-Origin', $origin);
        }

        if ($this->request->is(['post', 'put'])) {

            if ($this->Label->save($this->request->data)) {
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
            $options = ['conditions' => ['Label.' . $this->Label->primaryKey => $id]];
            $this->request->data = $this->Label->find('first', $options);
        }
        $locations = $this->Label->Location->find('list');
        $shipments = $this->Label->Shipment->find('list');

        $this->set(compact('locations', 'shipments'));
        $this->set('_serialize', ['locations', 'shipments']);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function editPallet($id = null)
    {
        if (!$this->Label->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }
        if ($this->request->is(['post', 'put'])) {

            if ($this->Label->save($this->request->data)) {
                $this->Flash->success(__('The pallet data has been saved.'));
                return $this->redirect($this->request->data['Label']['referer']);
                //return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The  pallet data could not be saved. Please, try again.'));
            }
        }
        $options = ['conditions' => ['Label.' . $this->Label->primaryKey => $id]];
        $label_info = $this->Label->find('first', $options);
        $label_info['Label']['qty_before'] = $label_info['Label']['qty'];
        $this->request->data = $label_info;
        //debug($label_info['Label']['item_id']);
        $item_data = $this->Label->Item->find('first', [
            'conditions' => [
                'Item.id' => $label_info['Label']['item_id']
            ],
            'contain' => true
        ]);

        $item_qty = $item_data['Item']['quantity'];
        $inventory_statuses = $this->Label->InventoryStatus->find('list');

        $productType = $this->Label->getProductType($id);
        $productTypeId = isset($productType['ProductType']['id'])
            ? $productType['ProductType']['id'] : 0;

        $availableLocations = $this->Label->getAvailableLocations('available', $productTypeId);

        $currentLocation = [
            $label_info['Location']['id'] =>
            $label_info['Location']['location']
        ];

        $locationsCombined = $availableLocations + $currentLocation;
        asort($locationsCombined, SORT_NATURAL);
        $locations = $locationsCombined;
        //Hash::sort($locationsCombined, '{n}', 'ASC', 'natural');

        //$locations = $this->Label->Location->find('list', ['order' => ['Location.location' => 'ASC']]);
        $shipments = $this->Label->Shipment->find('list');

        $this->request->data['Label']['qty_user_id'] = $this->Auth->user()['id'];
        $this->request->data['Label']['product_type_id'] = $item_data['ProductType']['id'];

        $this->request->data['Label']['referer'] = $this->referer();
        $restricted = $this->isAuthorized($this->Auth->user()) ? false : true;

        $this->set(
            compact(
                'item_qty',
                //'item_data',
                 'locations',
                'shipments',
                'inventory_statuses',
                'restricted'
            )
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function move($id = null)
    {
        if (!$this->Label->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        if ($this->request->is(['post', 'put'])) {

            $location_find = $this->Label->Location->find(
                'first', [
                    'conditions' => [
                        'Location.id' => $this->request->data['Label']['location_id']
                    ],
                    'recursive' => -1
                ]
            );

            $msg = sprintf(
                'Pallet moved from <strong>%s</strong> to <strong>%s</strong>',
                $this->request->data['Label']['previous_location'],
                $location_find['Location']['location']
            );

            // store the value the field was before changed

            if ($this->Label->save($this->request->data)) {
                $this->Flash->success($msg);

                return $this->redirect($this->request->data['Label']['referer']);
            } else {
                $this->Flash->error(__('The label could not be saved. Please, try again.'));
            }
        }
        $options = [
            'contain' => ['Location'],
            'conditions' => ['Label.' . $this->Label->primaryKey => $id]];
        $label_info = $this->Label->find('first', $options);

        $this->request->data = $label_info;
        $this->request->data['Label']['previous_location_id']
        = $label_info['Label']['location_id'];

        $locations = $this->Label->Location->find(
            'list',
            [
                'conditions' => [
                    'Location.' . $this->Label->Location->primaryKey =>
                    $label_info['Label']['location_id']
                ],
                'order' => [
                    'Location.location' => 'ASC'
                ]
            ]
        );

        $this->request->data['Label']['previous_location'] = $locations[$label_info['Label']['location_id']];

        $shipments = $this->Label->Shipment->find('list');
        $this->request->data['Label']['referer'] = $this->referer();

        $restricted = true;

        $productType = $this->Label->getProductType($id);
        $productTypeId = isset($productType['ProductType']['id'])
            ? $productType['ProductType']['id'] : 0;

        $availableLocations = $this->Label->getAvailableLocations('available', $productTypeId);

        $this->set(compact('locations', 'availableLocations'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id Delete a Label
     */
    public function delete($id = null)
    {
        // bug out on redirect to referer from auth component
        if ($this->request->is('get')) {
            return $this->redirect(['action' => 'index']);
        }
        $this->Label->id = $id;
        if (!$this->Label->exists()) {
            throw new NotFoundException(__('Invalid label'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Label->delete()) {
            $this->Flash->success(__('The label has been deleted.'));
        } else {
            $this->Flash->error(__('The label could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * locationStockLevels method
     *
     */
    public function locationSpaceUsage($filter = 'all')
    {
        $viewOptions = [
            'limit' => 800,
            'maxLimit' => 3000
        ];
        $options = $this->Label->locationSpaceUsageOptions($filter, 'all', $viewOptions);
        $this->paginate = $options;

        $locations = $this->Paginator->paginate();

        $this->set(compact('locations', 'filter'));
    }
}
