<?php

App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');

/**
 * Pallet Model
 *
 * @property Location $Location
 * @property Shipment $Shipment
 */
class Pallet extends AppModel
{

    //public $actsAs = array('Containable');
    /**
     * @var array
     */
    public $findMethods = ['palletsCartons' => true];

    /**
     * @var array
     */
    private $__fields = ['aisle_letter', 'col', 'level'];

    /**
     * @var mixed
     */
    private $__recordHasChanged = false;
    /**
     * @var array
     */
    private $__changed_fields = [];
    /**
     * @var array
     */
    private $__ignoreFields = ['referer', 'modified', 'location', 'aisle_letter', 'col', 'level'];

    /**
     * custom find method test
     *
     * @param state $state the state
     * @param query $query the $query
     * @param results $results the results
     * @return array return result
     */
    protected function _findPalletsCartons($state, $query, $results = [])
    {
        $this->log(['findPalletsCartons' => $state, $query, $results]);
        if ($state === 'before') {
            //$query['conditions']['Article.published'] = true;

            return $query;
        }

        return $results;
    }

    /**
     * @param array $results Results
     * @param bool $primary Primary model
     * @return mixed
     */
    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $value) {
            if (isset($value['Pallet']['location_id'])) {
                $results[$key]['Pallet']['previousLocationId'] = $value['Pallet']['location_id'];
            }
        }

        return $results;
    }

    /**
     * Legacy getWarehouseAislesColumnsLevels
     * @return array
     */
    public function getWarehouseAislesColumnsLevels()
    {
        # only margarine coolroom for put away
        $options = [
            'conditions' => [
                'Location.location LIKE' => 'MC%'
            ]
        ];

        $options['fields'] = ['SUBSTR(Location.location,3,1) as aisle_letter'];
        $options['group'] = ['SUBSTR(Location.location,3,1)'];

        $aisles = $this->Location->find('all', $options);

        $options['fields'] = ['SUBSTR(Location.location, 4,2) as col'];
        $options['group'] = ['SUBSTR(Location.location, 4,2)'];

        $columns = $this->Location->find('all', $options);

        $col_groups = $this->getSetting("WarehouseColumns");

        $columns = array_chunk($columns, $col_groups);

        $options['fields'] = ['SUBSTR(Location.location, -2) as level'];
        $options['group'] = ['SUBSTR(Location.location, -2)'];

        $levels = $this->Location->find('all', $options);

        return [
            $aisles, $columns, $levels
        ];
    }

    /**
     * @param array $keys Array of keys to check for
     * @param array $arr THe array to check
     *
     * @return bool
     */
    public function arrayKeysExists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }

    /**
     * @param array $data Data array to inspect
     * @return void
     */
    public function changeCooldownAndStatusIfAddingCartons($data)
    {
        /**
         * if we don't have all the keys needed to do the changeCooldownAndStatusIfAddingCartons
         * then exit without doing anything
         */
        $requiredFields = [
            'qty', 'item_id', 'qty_before',
            'inventory_status_id', 'product_type_id'
        ];

        if (!$this->arrayKeysExists($requiredFields, $data['Pallet'])) {
            return;
        }
        $qty = $data['Pallet']['qty'];
        $itemId = $data['Pallet']['item_id'];
        $productTypeId = $data['Pallet']['product_type_id'];
        $productType = $this->Item->ProductType->find(
            'first',
            [
                'recursive' => -1,
                'conditions' => [
                    'ProductType.id' => $productTypeId
                ]
            ]
        );

        $defaultStatus = $productType['ProductType']['inventory_status_id'];

        $qty_before = $data['Pallet']['qty_before'];

        $inventoryStatusId = $data['Pallet']['inventory_status_id'];

        // if adding cartons to pallet
        // update cooldown_date and set to wait status
        if ($defaultStatus && ($qty > $qty_before)) {
            $this->data['Pallet']['cooldown_date'] = date('Y-m-d H:i:s');
            if ((int)$inventoryStatusId === 0) {
                $this->data['Pallet']['inventory_status_id'] = $defaultStatus;
            }
        }
    }

    /**
     * Enumerate shifts enumShifts for a specific date
     *
     * @param array $query_date cakephp date object
     * @return array
     */
    public function enumShifts($query_date = null)
    {
        $shift_model = ClassRegistry::init('Shift');

        $shifts = $shift_model->find('all', [
            'conditions' => [
                'Shift.active' => 1,
                'Shift.for_prod_dt' => 0
            ]]);

        $date = $this->arrayToMysqlDate($query_date);
        $reports = [];
        $xml_shift_report = [];
        $ctr = 0;

        foreach ($shifts as $shift) {
            $start_time = $shift['Shift']['start_time'];
            $minutes = $shift['Shift']['shift_minutes'];

            $start_date_time = $date . ' ' . $start_time;
            $end_date_time = $this->addMinutesToDateTime($start_date_time, $minutes);

            $stop_time = $shift['Shift']['stop_time'];

            $productTypeId = $shift['ProductType']['id'];

            $shift_report = $this->getShiftReport(
                $date,
                $start_date_time,
                $end_date_time,
                $productTypeId,
                $shift
            );

            $reports[$ctr] = $shift_report;
            $reports[$ctr]['@shift_name'] = $shift['Shift']['name'];
            $reports[$ctr]['@start_time'] = $start_time;
            $reports[$ctr]['@stop_time'] = $stop_time;
            $reports[$ctr]['@start_date_time'] = $start_date_time;
            $reports[$ctr]['@end_date_time'] = $end_date_time;

            $xml_shift_report = array_merge(
                $xml_shift_report,
                $shift_report['report']
            );

            // $this-> log(['ctr' => $ctr, 'reports' => $reports]);

            $ctr++;
        }

        return ['reports' => $reports,
            'xml_shift_report' => $xml_shift_report];
    }

    /**
     * @param string $date Date
     * @param string $start_date_time Start Date Time
     * @param string $end_date_time End Date Time
     * @param int $productTypeId Product Type ID
     * @param array $shift Shift array
     * @return array
     */
    public function getShiftReport(
        $date,
        $start_date_time,
        $end_date_time,
        $productTypeId,
        $shift
    ) {
        $options = [
            'contain' => [
                'Item',
                'Carton'
            ],
            'fields' => [
                'Pallet.production_line',
                'Pallet.created',
                'Pallet.item',
                'Pallet.description',
                'Pallet.qty',
                'Item.quantity'
            ],
            'order' => [
                'Pallet.production_line',
                'Pallet.created'
            ],
            'conditions' => [
                'Pallet.created >= "' . $start_date_time . '"',
                'Pallet.created <= "' . $end_date_time . '"',
                'Pallet.product_type_id' => $productTypeId,
                'Pallet.qty !=' => 0
            ]

        ];

        $pallets = $this->find('all', $options);

        $report = [];
        $record_num = 0;
        $changed_product = true;
        $total = 0;
        $next_pallet = false;
        $current_item = '';
        $array_keys = array_keys($pallets);

        $last = end($array_keys);

        foreach ($pallets as $key => $pallet) {
            $line = $pallet['Pallet']['production_line'];
            $item = $pallet['Pallet']['item'];

            if ($current_item !== $line . $item) {
                $changed_product = true;
                $record_num++;
                $index = $key - 1;
                if (isset($pallets[$index])) {
                    $report[$record_num - 1]['last_pallet'] = $pallets[$index]['Pallet']['created'];
                    $report[$record_num - 1]['run_time'] = $this->getDateTimeDiff($report[$record_num - 1]['first_pallet'], $report[$record_num - 1]['last_pallet']);
                    $report[$record_num - 1]['pallets'] = $this->palletsDotCartons(
                        $report[$record_num - 1]['carton_total'],
                        $report[$record_num - 1]['standard_pl_qty']
                    );
                }

                $current_item = $line . $item;
            }
            if ($changed_product) {
                $report[$record_num]['report_date'] = $date;
                $report[$record_num]['shift_id'] = $shift['Shift']['id'];
                $report[$record_num]['shift'] = $shift['Shift']['name'];
                $report[$record_num]['standard_pl_qty'] = $pallet['Item']['quantity'];
                $report[$record_num]['production_line'] = $pallet['Pallet']['production_line'];
                $report[$record_num]['item'] = $pallet['Pallet']['item'];
                $report[$record_num]['description'] = $pallet['Pallet']['description'];
                $report[$record_num]['first_pallet'] = $pallet['Pallet']['created'];
                $report[$record_num]['carton_total'] = $pallet['Pallet']['qty'];
                $changed_product = false;
            } else {
                $report[$record_num]['carton_total'] += $pallet['Pallet']['qty'];
            }

            if ($key === $last) {
                $report[$record_num]['last_pallet'] = $pallet['Pallet']['created'];
                $report[$record_num]['run_time'] = $this->getDateTimeDiff($report[$record_num]['first_pallet'], $report[$record_num]['last_pallet']);
                $report[$record_num]['pallets'] = $this->palletsDotCartons(
                    $report[$record_num]['carton_total'],
                    $report[$record_num]['standard_pl_qty']
                );
            }
        }

        return ['report' => $report, 'shift' => $shift];
    }

    /**
     * @param array $data $this->data array
     * @return bool
     */
    public function isFloor($data)
    {
        return array_key_exists('floor', $data);
    }

    /**
     * @param int $id Location ID
     *
     * @return mixed
     */
    public function findLocationById($id)
    {
        $location = $this->Location->find('first', [
            'recursive' => -1,
            'conditions' => [
                'Location.id' => $id
            ]
        ]);

        return $location;
    }

    /**
     * @param int $id ProductType ID
     * @return mixed
     */
    public function getProductType($id)
    {
        $options = [
            'contain' => true,
            'fields' => ['ProductType.*'],
            'conditions' => [
                'Pallet.id' => $id
            ],
            'joins' => [
                [
                    'table' => 'items',
                    'alias' => 'Item',
                    'type' => 'INNER',
                    'conditions' => [
                        'Item.product_type_id = ProductType.id'
                    ]
                ],
                [
                    'table' => 'pallets',
                    'alias' => 'Pallet',
                    'type' => 'INNER',
                    'conditions' => [
                        'Pallet.item_id = Item.id'
                    ]
                ]
            ]
        ];

        $product_type = $this->Item->ProductType->find('first', $options);

        return $product_type;
    }

    /**
     * @param string $aisle Aisle Letter e.g A, B, C, D (in MCA0102, MCB0202 etc)
     * @return array
     */
    public function getColumnsAndLevels($aisle = null)
    {
        $options['conditions'] = [
            'Location.location LIKE ' => 'MC' . $aisle . '%',
            'Location.is_hidden' => 0
        ];
        $options['fields'] = ['SUBSTR(Location.location,3,1) as aisle_letter'];
        $options['group'] = ['SUBSTR(Location.location,3,1)'];

        //$maxdims = Hash::maxDimensions($locations_chunked[0]);
        //Hash::maxDimensions($locations_chunked);

        $aisles = $this->Location->find('all', $options);

        $options['fields'] = ['SUBSTR(Location.location, 4,2) as col'];
        $options['group'] = ['SUBSTR(Location.location, 4,2)'];

        $columns = $this->Location->find('all', $options);

        $col_groups = $this->getSetting('WarehouseColumns');
        $count = count($columns);

        $columns = array_chunk($columns, $col_groups);

        $options['fields'] = ['SUBSTR(Location.location, -2) as level'];
        $options['group'] = ['SUBSTR(Location.location, -2)'];

        $levels = $this->Location->find('all', $options);

        return [$aisles, $columns, $levels];
    }

    /**
     * @param string $locationName Location Name e.g. MCA0102
     *
     * @return mixed
     */
    public function getLocationIdFromLocationName($locationName)
    {
        $options = [
            'conditions' => [
                'Location.location' => $locationName
            ],
            'contain' => true
        ];

        return $this->Location->find('first', $options);
    }

    /**
     * @param array $pallets array of pallets from ->find call
     *
     * @return mixed
     */
    public function getDontShipCount($pallets = [])
    {
        $dont_ship_count = 0;

        foreach ($pallets as $pallet) {
            if ($pallet['Pallet']['dont_ship']) {
                $dont_ship_count++;
            }
        }

        return $dont_ship_count;
    }

    /**
     * @param array $contain the contain options [ Model => [ Model2 ]]
     * @return mixed
     */
    public function getViewOptions($contain = [])
    {
        $view_perms = $this->getViewPermNumber('view_in_stock');

        $options = [
            'recursive' => -1,
            'conditions' => [

                'OR' => [
                    // not shipped
                     'Shipment.shipped' => 0,
                    "Pallet.shipment_id" => 0
                ],
                'NOT' => [
                    // must have a location i.e. its been put-away
                     "Pallet.location_id" => 0
                ],
                'AND' => [
                    'OR' => [
                        'InventoryStatus.perms & ' . $view_perms,
                        'InventoryStatus.id IS NULL'
                    ]
                ]
            ],
            'order' => [
                // sort qad code
                 'Pallet.item' => 'ASC',
                // oldest first
                 'Pallet.pl_ref' => 'ASC'
            ],
            'limit' => 3000,
            'maxLimit' => 3000,
            'contain' => $contain
        ];

        return $options;
    }

    /**
     * @return mixed
     */
    public function getFilterValues()
    {
        $options = $this->getViewOptions($contain = ['Shipment', 'InventoryStatus']);

        $options['fields'] = [
            'Pallet.item_id',
            'CONCAT(Pallet.item, " - ",  Pallet.description, " (", COUNT(Pallet.item_id), ")") as item_code_desc'
        ];
        $options['group'] = [
            'Pallet.item_id'
        ];

        $item_codes_qry = $this->find('all', $options);

        $item_codes = Hash::combine(
            $item_codes_qry,
            '{n}.Pallet.item_id',
            '{n}.{n}.item_code_desc'
        );
        // creates this array
        // [58510] => 58510 - HOMEBRAND SPD 4KG
        // [58549] => 58549 - WOW SELECT OLIVE 500G
        // [60002] => 60002 - HA CANOLA OIL 20L
        // [60004] => 60004 - HA COTTON OIL 20L
        # add the oil and marg search prefixes

        $productTypes = $this->Item->ProductType->find(
            'list',
            [
                'conditions' => [
                    'ProductType.active' => 1
                ],
                'recursive' => -1
            ]
        );

        $prependTypes = [];
        foreach ($productTypes as $key => $pt) {
            $prependTypes['product-type-' . $key] = $pt;
        }

        $prepend = $prependTypes + ['low_dated' => 'Low Dated'];

        // the above add the 5 and 6 to end of array so use
        // ksort to sort to
        // [5] => Marg
        // [6] => Oil
        // [5xxxx] ...
        // [6xxxx] ...
        //ksort($item_codes, SORT_REGULAR);

        return $prepend + $item_codes;
    }

    /**
     * @param array $data $this->data array
     * @return array
     */
    protected function _stripBlankValues($data)
    {
        return Hash::filter($data);
    }

    /**
     * @param array $passed_args passed from Pallets/lookup view / action
     * @return mixed
     */
    public function formatLookupRequestData($passed_args = [])
    {
        $data_array = [];
        foreach ($this->_stripBlankValues($passed_args) as $arg_key => $args) {
            if (strpos($arg_key, 'Lookup.') !== false) {
                $search_value = explode('.', $arg_key)[1];
                $data_array['Lookup'][$search_value] = $args;
            }
        }

        return $data_array;
    }

    /**
     * @param null $startDateTime Start Datetime
     * @param null $endDateTime End Datetime
     * @param int $productTypeId Product Type ID
     * @return array
     */
    public function getCartonsBetweenDateTimes($startDateTime = null, $endDateTime = null, $productTypeId = null)
    {
        /*
        //  (((( `Pallet`.`product_type_id` = 1)
        AND ((`Shipment`.`shipped` IS NULL)
        OR (`Shipment`.`shipped` = 0)))
        AND (((`Pallet`.`print_date` >= '2019-12-02 5:00:00')
        AND (`Pallet`.`print_date` <= '2019-12-02 15:00:00')))))

         */
        $cartonFindOptions = [
            'conditions' => [
                'AND' => [
                    'Pallet.product_type_id' => $productTypeId,
                    'OR' => [
                        'Shipment.shipped IS NULL',
                        'Shipment.shipped' => 0
                    ],
                    'OR' => [
                        [
                            'Pallet.print_date >=' => $startDateTime,
                            'Pallet.print_date <=' => $endDateTime
                        ],
                        [
                            'Pallet.qty_modified >=' => $startDateTime,
                            'Pallet.qty_modified <=' => $endDateTime
                        ]
                    ]
                ]
            ],
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
                'ProductionLine'
            ],
            'fields' => [
                'ProductionLine.name',
                'Pallet.item_id',
                'Pallet.description',
                'Pallet.item',
                'Pallet.qty_modified',
                'Pallet.qty',
                'Pallet.qty_previous',
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
                    'cartonRecordCount > 1',
                    'Item.quantity <> Pallet.qty'
                ]
            ],
            'order' => [
                'Pallet.print_date' => 'ASC'
            ],
            'recursive' => -1
        ];

        return $this->find('all', $cartonFindOptions);
    }

    /**
     * @param array $queryDate from shift Report form
     *
     * @return array
     */
    public function shiftReport($queryDate = null)
    {
        $shift_model = ClassRegistry::init('Shift');

        $shifts = $shift_model->find('all', [
            'conditions' => [
                'Shift.active' => 1,
                'Shift.for_prod_dt' => 0
            ]]);

        $date = $this->arrayToMysqlDate($queryDate);
        $reports = [];
        $xml_shift_report = [];
        $ctr = 0;

        foreach ($shifts as $shift) {
            $start_time = $shift['Shift']['start_time'];
            $minutes = $shift['Shift']['shift_minutes'];

            $start_date_time = $date . ' ' . $start_time;
            $end_date_time = $this->addMinutesToDateTime($start_date_time, $minutes);

            $stop_time = $shift['Shift']['stop_time'];

            $productTypeId = $shift['ProductType']['id'];

            $shift_report = $this->getShiftReport(
                $date,
                $start_date_time,
                $end_date_time,
                $productTypeId,
                $shift
            );

            $cartons_report = $this->getCartonsBetweenDateTimes($start_date_time, $end_date_time, $productTypeId);

            $reports[$ctr] = $shift_report;
            $reports[$ctr]['Cartons'] = $cartons_report;
            $reports[$ctr]['@shift_name'] = $shift['Shift']['name'];
            $reports[$ctr]['@start_time'] = $start_time;
            $reports[$ctr]['@stop_time'] = $stop_time;
            $reports[$ctr]['@start_date_time'] = $start_date_time;
            $reports[$ctr]['@end_date_time'] = $end_date_time;

            $xml_shift_report = array_merge(
                $xml_shift_report,
                $shift_report['report']
            );

            // $this-> log(['ctr' => $ctr, 'reports' => $reports]);

            $ctr++;
        }

        return ['reports' => $reports,
            'xml_shift_report' => $xml_shift_report];
    }

    /**
     * @param array $passed_args args as array
     *
     *
     * @return mixed
     */
    public function formatLookupActionConditions($passed_args = [])
    {
        $options = [];

        foreach ($this->_stripBlankValues($passed_args) as $arg_key => $args) {
            // only interested in Lookup.xxx not page=2 etc
            if (strpos($arg_key, 'Lookup.') !== false) {
                $search_value = explode('.', $arg_key)[1];

                if ($search_value === 'item_id_select') {
                    $options[] = ['Item.code' => $args];
//                } elseif ($search_value === 'bb_date') {
                    //                    $options[] = array($search_value => CakeTime::format($args, '%d/%m/%y'));
                } elseif ($search_value === 'print_date') {
                    $options[] = [$search_value . ' LIKE ' => $args . '%'];
                } else {
                    $options[] = [$search_value => $args];
                }
            }
        }

        return $options;
    }

    /**
     * @param array $check param to check
     * @return mixed
     */
    public function checkEnableShipLowDate($check)
    {
        $dont_ship = (int)$this->data[$this->alias]['dont_ship'];
        $ship_low_date = (int)$check['ship_low_date'];

        $allow = (
            ($dont_ship === 1 && $ship_low_date === 1) ||
            ($dont_ship === 1 && $ship_low_date === 0) ||
            ($dont_ship === 0 && $ship_low_date === 0)

        ) ? true : false;

        return $allow;
    }

    /**
     * check that the inventory_status_id can be changed
     * if on a shipper it can't
     * @param array $check Check array
     * @return bool
     * phpcs:disable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
     */
    public function checkChangeOK($check)
    {
        $validator = $this->validator();

        $msg = 'You cannot change the status of a pallet that is already on a shipment<br>';
        // <a title="Click here to edit the shipment" href="' . Router::url(['controller' => 'shipments', 'action' => 'edit',$this->data[$this->alias]['shipment_id'] ]) . '">

        $this->old = $this->find(
            'first',
            [
                'conditions' =>
                [
                    'Pallet.id' => $this->data[$this->alias]['id']
                ]
            ]
        );

        $validator['inventory_status_id']['checkChangeOK']->message = $msg;
        //return  && $this->data[$this->alias]['inventory_status_id'] == 0;
        $statusHaschanged = $this->data[$this->alias]['inventory_status_id'] !== $this->old['Pallet']['inventory_status_id'];

        $hasShipment = $this->data[$this->alias]['shipment_id'] !== 0;
        // return true for ok and false for not ok

        $noShipment = $this->data[$this->alias]['shipment_id'] == 0;

        return !($statusHaschanged && $hasShipment) || $noShipment;
    }

    // phpcs:enable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps

    /**
     * Set Minimum Days Life
     * Queries the Item table for the min_days_life setting and if not > 0 sets the $this->data to the global value
     * @return void
     */
    public function setMinimumDaysLife()
    {
        if (!empty($this->data[$this->alias]['item_id'])) {
            $item = $this->Item->findById($this->data[$this->alias]['item_id']);
            $item_min_days_life = $item['Item']['min_days_life'];
            $daysLife = $item_min_days_life > 0 ? $item_min_days_life : $this->getGlobalMinDaysLife();
            $this->data[$this->alias]['min_days_life'] = $daysLife;
        }
    }

    /**
     *
     * @param string $pallet_ref Pallet reference e.g. B1234567, 00123456
     * @param array $return_value The array containing the return value of the process
     * @param string $printerName Print friendly name e.g "PDF Printer" or "CAB Bottling"
     * @param bool $debugMode True if the CAKEPHP_DEBUG value is > 0
     *
     * @return array An array of strings
     */
    public function createSuccessMessage($pallet_ref, $return_value, $printerName, $debugMode = false)
    {
        $debugText = '';
        $alertType = $return_value['return_value'] !== 0 ? 'error' : 'success';
        $msgString = '%s Pallet No. <strong>%s</strong> has been';
        $msgString .= ' sent to <strong>%s</strong>';

        if ($debugMode) {
            $debugText = "<strong>IN DEBUG MODE: </strong>";
            $debugText .= $alertType === 'error' ? $return_value['stderr'] : "";
        }

        return [
            'type' => $alertType,
            'msg' => sprintf($msgString, $debugText, $pallet_ref, $printerName)
        ];
    }

    /**
     * Generate an SSCC number with check digit
     *
     * @return string
     *
     * phpcs:disable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
     */
    public function generateSSCCWithCheckDigit()
    {
        $sscc = $this->generateSSCC();

        return $sscc . $this->generateCheckDigit($sscc);
    }

    /**
     * @return mixed
     */
    public function generateSSCC()
    {
        $settings = ClassRegistry::init('Setting');
        $sscc_ext = $this->getSetting('sscc_extension_digit');
        $sscc_co = $this->getSetting('sscc_company_prefix');
        $sscc_ref = $settings->getReferenceNumber('sscc_ref', 'sscc');

        return $sscc_ext . $sscc_co . $sscc_ref;
    }

    // phpcs:enable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps

    /**
     * when fed a barcode number returns the GS1 checkdigit number
     * @param string $number barcode number
     * @return string barcode number
     */
    public function generateCheckDigit($number)
    {
        $sum = 0;
        $index = 0;
        $cd = 0;
        for ($i = strlen($number); $i > 0; $i--) {
            $digit = substr($number, $i - 1, 1);
            $index++;

            $ret = $index % 2;
            if ($ret == 0) {
                $sum += $digit * 1;
            } else {
                $sum += $digit * 3;
            }
        }
        $mod_sum = $sum % 10;
        # if it exactly divide the checksum is 0
        if ($mod_sum == 0) {
            $cd = 0;
        } else {
            # go to the next multiple of 10 above and subtract
            $cd = ((10 - $mod_sum) + $sum) - $sum;
        }

        return $cd;
    }

    /**
     * @return mixed
     */
    public function hasQtyChanged()
    {
        if ($this->id && isset($this->data['Pallet']['qty'])) {
            $qty_before = $this->old['Pallet']['qty'];
            $qty_now = $this->data['Pallet']['qty'];

            $ret = (int)$qty_before !== (int)$qty_now;

            return $ret;
        }

        return false;
    }

    /**
     * Update $this->data so pallet.qty_previous and pallet.qty_modifed change when pallet.qty changes
     * @return void
     */
    public function updateQtyPreviousWhenQtyChange()
    {
        if ($this->hasQtyChanged()) {
            $qty_before = $this->old['Pallet']['qty'];

            $this->data['Pallet']['qty_previous'] = $qty_before;
            $this->data['Pallet']['qty_modified'] = $this->getDateTimeStamp();
        } else {
            unset($this->data['Pallet']['qty_user_id']);
        }
    }

    /**
     * @return void
     */
    public function updateInventoryStatusDateTime()
    {
        if (!empty($this->data[$this->alias]['inventory_status_id'])) {
            if ($this->old) {
                if ($this->old[$this->alias]['inventory_status_id'] != $this->data[$this->alias]['inventory_status_id']) {
                    $this->data[$this->alias]['inventory_status_datetime'] = date('Y-m-d H:i:s');
                }
            }
        }
    }

    /**
     * sets $__recordHasChanged to true if when checking the fields listed in $__changed_fields
     * against $this->old (the old record in DB) against $this->data
     *
     * @return void
     */
    public function updateHasRecordChanged()
    {
        if ($this->old) {
            unset($this->old[$this->alias]['modified']);

            $this->__changed_fields = [];

            foreach ($this->data[$this->alias] as $key => $value) {
                if (isset($this->old[$this->alias][$key])) {
                    if ($this->old[$this->alias][$key] != $value) {
                        $this->__changed_fields[] = $key;
                    }
                } else {
                    if (!empty($value) && !in_array($key, $this->__ignoreFields)) {
                        $this->__changed_fields[] = $key;
                    }
                }
            }

            $this->__recordHasChanged = (bool)count($this->__changed_fields);
        }
    }

    // this sets the min_days_life value either to the global value
    // or to the one in the items table

    /**
     *
     * @param array $options Options array
     * @return void
     */
    public function beforeSave($options = [])
    {
        $this->changeCooldownAndStatusIfAddingCartons($this->data);

        $this->setMinimumDaysLife();

        if ($this->id) {
            $this->recursive = -1;
            $this->old = $this->findById($this->data[$this->alias]['id']);
        }

        $this->updateInventoryStatusDateTime();

        $this->updateQtyPreviousWhenQtyChange();

        $this->updateHasRecordChanged();
    }

    /**
     * @param bool $created set to true if new DB record created
     * @param array $options Options array
     * @return void
     */
    public function afterSave($created, $options = [])
    {
        if ($created) {
            $palletId = $this->id;
            $cartonQty = $this->data[$this->alias]['qty'];
            $productionDate = $this->data[$this->alias]['print_date'];
            $bb_date = $this->data[$this->alias]['bb_date'];

            $formattedDate = $this->formatLabelDates(
                strtotime($productionDate),
                [
                    'production_date' => 'Y-m-d'
                ]
            );

            $cartons = [
                'pallet_id' => $palletId,
                'count' => $cartonQty,
                'production_date' => $formattedDate['production_date'],
                'best_before' => $bb_date
            ];

            $this->Carton->create();

            if ($this->Carton->save($cartons)) {
                $this->log("OK Saved Carton");
            } else {
                $this->log("It's an error");
            };
        }
    }

    /**
     * @param array $sndata $this->data
     * @return mixed
     */
    public function inventoryStatusNote($sndata)
    {
        $inventory_status_note = '';

        if (
            isset($sndata['inventory_status_note_global'])
            && !empty($sndata['inventory_status_note_global'])
        ) {
            $inventory_status_note = $sndata['inventory_status_note_global'];
        }

        return $inventory_status_note;
    }

    /**
     * @return mixed
     */
    public function getGlobalMinDaysLife()
    {
        return $this->getSetting('min_days_life');
    }

    /**
     * @var array
     */
    public $virtualFields = [
        'code_desc' => 'CONCAT( Pallet.pl_ref, ": ", Pallet.item, " - " , Pallet.description)',
        'best_before' => 'DATE_FORMAT(Pallet.bb_date, "%d/%m/%y")',
        'name' => 'CONCAT( Pallet.item, " " , Pallet.description, " " , Pallet.pl_ref)',
        'sscc_fmt' => 'CONCAT( LEFT(Pallet.sscc,1) , " ", MID(Pallet.sscc, 2,7) , " ", MID(Pallet.sscc,9,9) , " ",  RIGHT(Pallet.sscc,1) )',
        'dont_ship' => 'DATEDIFF(Pallet.bb_date, CURDATE()) < Pallet.min_days_life AND Pallet.shipment_id = 0'
    ];
    /**
     * @var string
     */
    public $displayField = 'name';

    /**
     * @param string $term snippet of pallet reference from any part of pl_ref
     * @return mixed
     */
    public function palletReferenceLookup($term)
    {
        $cond = ['Pallet.pl_ref LIKE' => '%' . $term . '%'];

        $options = [
            'fields' => [
                'Pallet.pl_ref',
                'Pallet.code_desc'
            ],
            'conditions' => [
                'Pallet.pl_ref IS NOT NULL',
                'Pallet.pl_ref !=' => '',
                $cond
            ],
            'order' =>
            [
                'Pallet.pl_ref' => 'ASC'
            ]
        ];
        $pl_ref = $this->find('all', $options);

        $pl_refs = Hash::map($pl_ref, '{n}.Pallet', [$this, 'formatLookup']);

        return $pl_refs;
    }

    /**
     * @param array $filter ?
     * @param int $productTypeId Product Type ID
     * @return mixed
     */
    public function getAvailableLocations($filter, $productTypeId)
    {
        $options = $this->locationSpaceUsageOptions($filter, $productTypeId);

        $available = $this->find('all', $options);

        $availableLocations = Hash::combine($available, '{n}.Pallet.LocationId', '{n}.Pallet.Location', $groupPath = null);

        return $availableLocations;
    }

    /**
     * @param int $locationId Location ID
     * @return mixed
     */
    public function getCapacity($locationId)
    {
        $options = [
            'contain' => true,
            'conditions' => [
                'Location.id' => $locationId
            ]
        ];
        $locationDetails = $this->Location->find('first', $options);

        return $locationDetails['Location']['pallet_capacity'];
    }

    /**
     * locationSpaceUsageOptions method
     * @param string $filter string of either 'all' or 'available'
     * @param string $productTypeId if productTypeId is all then no filter other wise pass in ID
     * @param array ExtraOptions $extraOptions some more conditions to add to $options array
     * @return array returns an option array configured correctly to find location availability
     */
    public function locationSpaceUsageOptions($filter, $productTypeId = 'all', $extraOptions = [])
    {
        $this->virtualFields['Pallets'] = 'COU  NT(Pallet.id)';
        $this->virtualFields['hasSpace'] = 'COUNT(Pallet.id) < Location.pallet_capacity';
        $this->virtualFields['LocationId'] = 'Location.id';
        $this->virtualFields['pallet_capacity'] = 'Location.pallet_capacity';
        $this->virtualFields['Location'] = 'Location.location';

        $options = [
            'recursive' => -1,
            'fields' => [
                'COUNT(Pallet.id) AS Pallet__Pallets',
                'COUNT(Pallet.id) < Location.pallet_capacity as Pallet__hasSpace',
                'Location.id  AS Pallet__LocationId',
                'Location.pallet_capacity AS Pallet__pallet_capacity',
                'Location.location AS Pallet__Location'
            ],
            'joins' => [
                [
                    'table' => 'shipments',
                    'alias' => 'Shipment',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Pallet.shipment_id = Shipment.id',
                        'Shipment.shipped' => 0
                    ]
                ],
                [
                    'table' => 'locations',
                    'alias' => 'Location',
                    'type' => 'RIGHT',
                    'conditions' => [
                        '( 	Pallet.location_id = Location.id AND
							Pallet.location_id <> 0 AND
							Pallet.inventory_status_id <> 2 AND
							Pallet.picked <> true ) AND
						(
							( Pallet.shipment_id = 0 ) OR
							( Pallet.shipment_id <> 0 AND Shipment.shipped IS NOT NULL))'
                    ]
                ]
            ],
            'order' => [
                'Location.location' => 'ASC'
            ],
            'group' => [
                'Location.id'
            ]
        ];

        $having = [
            'having' => [
                'Location.pallet_capacity > COUNT(Pallet.id)'
            ]
        ];

        if ($productTypeId !== 'all') {
            $options['conditions'] = [
                'Location.product_type_id' => $productTypeId
            ];
        }

        if ($filter === 'available') {
            $options += $having;
        }
        if ($extraOptions) {
            $options += $extraOptions;
        }

        return $options;
    }

    /**
     * @param array $check Check array
     * @return mixed
     */
    public function hasCapacityInLocation($check)
    {
        $locationId = $check['location_id'];

        // skip validation if the edit is not a move
        if (
            isset($this->data['Pallet']['previousLocationId'])
            && !empty($this->data['Pallet']['previousLocationId'])
            && $locationId === $this->data['Pallet']['previousLocationId']
        ) {
            return true;
        }

        $location = $this->findLocationById($locationId);

        $capacity = $this->getCapacity($locationId);

        $options = [
            'recursive' => -1,
            'joins' => [[
                'table' => 'shipments',
                'alias' => 'Shipment',
                'type' => 'LEFT',
                'conditions' => [
                    'Pallet.shipment_id = Shipment.id'
                ]]
            ],
            'conditions' => [
                'OR' => [
                    [
                        'Pallet.location_id' => $locationId,
                        'Pallet.shipment_id' => 0,
                        'Pallet.inventory_status_id <> 2'
                    ],
                    [
                        'Pallet.location_id' => $locationId,
                        'Pallet.shipment_id <> 0',
                        'Pallet.picked = 0',
                        'Shipment.shipped = 0',
                        'Pallet.inventory_status_id <> 2'
                    ]
                ]
            ]
        ];

        $palletsInLocation = $this->find('count', $options);

        if (!($palletsInLocation < $capacity)) {
            $this->validator()
                ->getField('location_id')
                ->getRule('checkCapacity')
                ->message = sprintf(
                    "%s is full. It already contains %d pallets and has a capacity of %d. Please put the pallet in another location",
                    $location['Location']['location'],
                    $palletsInLocation,
                    $capacity
                );
        }

        return $palletsInLocation < $capacity;
    }

    /**
     * @param string $term Snippet of batch no. to search for
     * @return mixed
     */
    public function batchLookup($term)
    {
        $options = [
            'fields' => [
                'DISTINCT(Pallet.batch) as batch',
                'Pallet.print_date'
            ],
            'conditions' => [
                'Pallet.batch LIKE' => '%' . $term . '%'
            ],
            'group' => [
                'Pallet.batch'
            ],
            'recursive' => -1
        ];

        $batches = $this->find('all', $options);

        $batches = Hash::map($batches, '{n}.Pallet', [$this, 'formatBatch']);

        return $batches;
    }

    /**
     * @param array $data $this->data
     * @return array
     */
    public function formatBatch($data)
    {
        return [
            'value' => $data['batch'],
            'label' => $data['batch'] . " - " . CakeTime::format($data['print_date'], '%a %d/%m/%Y', 'invalid')
        ];
    }

    /**
     * Format for a Javascript control somewhere
     * @param array $pl_data Pallet Data array
     * @return array
     */
    public function formatLookup($pl_data)
    {
        return [
            'label' => $pl_data['code_desc'],
            'value' => $pl_data['pl_ref']
        ];
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'ship_low_date' => [
            'checkEnableShipLowDate' => [
                'rule' => 'checkEnableShipLowDate',
                'on' => 'update',
                'message' => "The ship low dated checkbox can only be checked if the pallet is low dated"
            ]
        ],
        'inventory_status_id' => [
            'checkChangeOK' => [
                'rule' => 'checkChangeOK',
                'on' => 'update'
                //'message' => "You cannot change the status of a pallet on a shipper. Remove it from the shipper first"
            ]
        ],
        'item' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'description' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        /* 'best_before' => [
        'notEmpty' => [
        'rule' => 'notBlank',
        //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        ],
        ] , */

        'gtin14' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'qty' => [
            'numeric' => [
                'rule' => ['numeric']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'pl_ref' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'notTooLong' => [
                'rule' => ['maxLength', 19],
                'message' => 'Maximum length for a pallet reference is 19 characters.
                Please check the Product Type "Serial number format"'
            ]
        ],
        'sscc' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'batch_no' => [
            'notEmpty' => 'notBlank',
            'message' => 'Please select a batch number',
            'on' => 'create'
        ],
        'batch' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'printer' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'print_date' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'location_id' => [
            'mustBeNumeric' => [
                'rule' => ['numeric']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'checkCapacity' => [
                'rule' => 'hasCapacityInLocation',
                'on' => 'update',
                'message' => 'Location full. Please choose another location'
            ]
        ],
        'shipment_id' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                 'allowEmpty' => true
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ]
    ];

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * @var array
     */
    public $hasMany = [
        'Carton' => [
            'className' => 'Carton',
            'foreignKey' => 'pallet_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
    ];
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'ProductType' => [
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'ProductionLine' => [
            'className' => 'ProductionLine',
            'foreignKey' => 'production_line_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Printer' => [
            'className' => 'Printer',
            'foreignKey' => 'printer_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Location' => [
            'className' => 'Location',
            'foreignKey' => 'location_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Shipment' => [
            'className' => 'Shipment',
            'foreignKey' => 'shipment_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ],
        'Item' => [
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'InventoryStatus' => [
            'className' => 'InventoryStatus',
            'foreignKey' => 'inventory_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'User' => [
            'className' => 'User',
            'foreignKey' => 'qty_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];
}