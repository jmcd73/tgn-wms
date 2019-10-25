<?php

App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');

/**
 * Label Model
 *
 * @property Location $Location
 * @property Shipment $Shipment
 */
class Label extends AppModel
{

    //public $actsAs = array('Containable');

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
     * @param $results
     * @param $primary
     * @return mixed
     */
    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $value) {
            if (isset($value['Label']['location_id'])) {
                $results[$key]['Label']['previousLocationId'] = $value['Label']['location_id'];
            }
        }
        return $results;
    }

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
     * @param array $keys
     * @param array $arr
     */
    public function array_keys_exists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }

    /**
     * @param $data
     * @return null
     */
    public function changeCooldownAndStatusIfAddingCartons($data)
    {

        /**
         * if we don't have all the keys needed to do the changeCooldownAndStatusIfAddingCartons
         * then exit without doing anything
         */
        $requiredFields = ['qty', 'item_id', 'qty_before', 'inventory_status_id', 'product_type_id'];
        if (!$this->array_keys_exists($requiredFields, $data['Label'])) {
            return;
        }
        $qty = $data['Label']['qty'];
        $itemId = $data['Label']['item_id'];
        $productTypeId = $data['Label']['product_type_id'];
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

        $qty_before = $data['Label']['qty_before'];

        $inventoryStatusId = $data['Label']['inventory_status_id'];

        // if adding cartons to pallet
        // update cooldown_date and set to wait status
        if ($defaultStatus && ($qty > $qty_before)) {
            $this->data['Label']['cooldown_date'] = date('Y-m-d H:i:s');
            if ((int)$inventoryStatusId === 0) {
                $this->data['Label']['inventory_status_id'] = $defaultStatus;
            }
        }
    }

    /**
     * @param $itemId
     * @param $productName
     * @return mixed
     */
    public function isProduct($itemId, $productName)
    {
        $options = [
            'contain' => [
                'ProductType'
            ],
            'conditions' => [
                'Item.id' => $itemId
            ]
        ];
        $item = $this->Item->find('first', $options);

        return $item['ProductType']['name'] === $productName;
    }

    /**
     * @param $query_date
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

            $item_prefix = $shift['ProductType']['code_prefix'];

            $shift_report = $this->getShiftReport($date, $start_date_time, $end_date_time, $item_prefix, $shift);

            $reports[$ctr] = $shift_report;
            $reports[$ctr]['@shift_name'] = $shift['Shift']['name'];
            $reports[$ctr]['@start_time'] = $start_time;
            $reports[$ctr]['@stop_time'] = $stop_time;
            $reports[$ctr]['@start_date_time'] = $start_date_time;
            $reports[$ctr]['@end_date_time'] = $end_date_time;

            $xml_shift_report = array_merge($xml_shift_report, $shift_report['report']);

            // $this-> log(['ctr' => $ctr, 'reports' => $reports]);

            $ctr++;

        }

        return ['reports' => $reports,
            'xml_shift_report' => $xml_shift_report];

    }

    /**
     * @param $date
     * @param $start_date_time
     * @param $end_date_time
     * @param $item_prefix
     * @param $shift
     * @param $request
     */
    public function getShiftReport($date, $start_date_time, $end_date_time, $item_prefix, $shift, $request = null)
    {

        $options = [
            'contain' => [
                'Item'
            ],
            'fields' => [
                'Label.production_line',
                'Label.created',
                'Label.item',
                'Label.description',
                'Label.qty',
                'Item.quantity'
            ],
            'order' => [
                'Label.production_line',
                'Label.created'
            ],
            'conditions' => [
                'Label.created >= "' . $start_date_time . '"',
                'Label.created <= "' . $end_date_time . '"',
                'Label.item LIKE "' . $item_prefix . '%"',
                'Label.qty !=' => 0
            ]

        ];

        $labels = $this->find('all', $options);

        $report = [];
        $record_num = 0;
        $changed_product = true;
        $total = 0;
        $next_pallet = false;
        $current_item = '';
        $array_keys = array_keys($labels);

        $last = end($array_keys);

        foreach ($labels as $key => $label) {

            $line = $label['Label']['production_line'];
            $item = $label['Label']['item'];

            if ($current_item !== $line . $item) {

                $changed_product = true;
                $record_num++;
                $index = $key - 1;
                if (isset($labels[$index])) {
                    $report[$record_num - 1]['last_pallet'] = $labels[$index]['Label']['created'];

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
                $report[$record_num]['standard_pl_qty'] = $label['Item']['quantity'];
                $report[$record_num]['production_line'] = $label['Label']['production_line'];
                $report[$record_num]['item'] = $label['Label']['item'];
                $report[$record_num]['description'] = $label['Label']['description'];
                $report[$record_num]['first_pallet'] = $label['Label']['created'];
                $report[$record_num]['carton_total'] = $label['Label']['qty'];
                $changed_product = false;
            } else {
                $report[$record_num]['carton_total'] += $label['Label']['qty'];
            }

            if ($key === $last) {
                $report[$record_num]['last_pallet'] = $label['Label']['created'];
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
     * @param $data
     */
    public function isFloor($data)
    {
        return array_key_exists('floor', $data);
    }


    /**
     * @param $id
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
     * @param $id
     * @return mixed
     */
    public function getProductType($id)
    {

        $options = [
            'contain' => true,
            'fields' => ['ProductType.*'],
            'conditions' => [
                'Label.id' => $id
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
                    'table' => 'labels',
                    'alias' => 'Label',
                    'type' => 'INNER',
                    'conditions' => [
                        'Label.item_id = Item.id'
                    ]
                ]
            ]
        ];

        $product_type = $this->Item->ProductType->find('first', $options);
        return $product_type;

    }

    /**
     * @param $aisle
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
     * @param $locationName
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
     * @param array $labels
     * @return mixed
     */
    public function getDontShipCount($labels = [])
    {
        $dont_ship_count = 0;

        foreach ($labels as $label) {
            if ($label['Label']['dont_ship']) {
                $dont_ship_count++;
            }
        }
        return $dont_ship_count;
    }

    /**
     * @param array $contain
     * @return mixed
     */
    public function getViewOptions($contain = [])
    {

        $view_perms = $this->getViewPermNumber('view_in_stock');

        $options = [
            'conditions' => [
                # not shipped
                 'OR' => [
                    'Shipment.shipped' => 0,
                    "Label.shipment_id" => 0
                ],
                # must have a location i.e. its been put-away
                 'NOT' => [
                    "Label.location_id" => 0
                ],
                'AND' => [
                    'OR' => [
                        'InventoryStatus.perms & ' . $view_perms,
                        'InventoryStatus.id IS NULL'
                    ]
                ]
            ],
            'order' => [
                # sort qad code
                 'Label.item' => 'ASC',
                # oldest first
                 'Label.pl_ref' => 'ASC'
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
            'Label.item_id',
            'CONCAT(Label.item, " - ",  Label.description, " (", COUNT(Label.item_id), ")") as item_code_desc'
        ];
        $options['group'] = [
            'Label.item_id'
        ];

        $item_codes_qry = $this->find('all', $options);

        $item_codes = Hash::combine(
            $item_codes_qry,
            '{n}.Label.item_id',
            '{n}.{n}.item_code_desc'
        );
        // creates this array
        // [58510] => 58510 - HOMEBRAND SPD 4KG
        // [58549] => 58549 - WOW SELECT OLIVE 500G
        // [60002] => 60002 - HA CANOLA OIL 20L
        // [60004] => 60004 - HA COTTON OIL 20L
        # add the oil and marg search prefixes

        $productTypes = $this->Item->ProductType->find(
            'list', [
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
     * @param $data
     */
    private function __stripBlankValues($data)
    {
        return Hash::filter($data);
    }

    /**
     * @param array $passed_args
     * @return mixed
     */
    public function formatLookupRequestData($passed_args = [])
    {

        $data_array = [];
        foreach ($this->__stripBlankValues($passed_args) as $arg_key => $args) {
            if (strpos($arg_key, 'Lookup.') !== false) {
                $search_value = explode('.', $arg_key)[1];
                $data_array['Lookup'][$search_value] = $args;
            }
        }
        return $data_array;
    }

    /**
     * @param array $passed_args
     * @return mixed
     */
    public function formatLookupActionConditions($passed_args = [])
    {
        $options = [];

        foreach ($this->__stripBlankValues($passed_args) as $arg_key => $args) {

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
     * @param $check
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
     */
    public function checkChangeOK($check)
    {

        $validator = $this->validator();

        $msg = 'You cannot change the status of a pallet that is already on a shipment<br>';
        // <a title="Click here to edit the shipment" href="' . Router::url(['controller' => 'shipments', 'action' => 'edit',$this->data[$this->alias]['shipment_id'] ]) . '">

        $this->old = $this->find('first', ['conditions' =>
            [
                'Label.id' => $this->data[$this->alias]['id']
            ]
        ]
        );

        $validator['inventory_status_id']['checkChangeOK']->message = $msg;
        //return  && $this->data[$this->alias]['inventory_status_id'] == 0;
        $statusHaschanged = $this->data[$this->alias]['inventory_status_id'] !== $this->old['Label']['inventory_status_id'];

        $hasShipment = $this->data[$this->alias]['shipment_id'] !== 0;
        // return true for ok and false for not ok

        $noShipment = $this->data[$this->alias]['shipment_id'] == 0;

        return !($statusHaschanged && $hasShipment) || $noShipment;
    }

    public function setDaysLife()
    {

        $globalLife = $this->getGlobalMinDaysLife();

        if (!empty($this->data[$this->alias]['item_id'])) {
            $item = $this->Item->findById($this->data[$this->alias]['item_id']);
            $item_min_days_life = $item['Item']['min_days_life'];
            $daysLife = (bool)$item_min_days_life ? $item_min_days_life : $globalLife;
            $this->data[$this->alias]['min_days_life'] = $daysLife;
        }
    }

    /**
     *
     * @param type $pallet_ref
     * @param type $return_value
     * @param type $debugMode
     * @return string
     */
    public function createSuccessMessage($pallet_ref, $return_value = [], $printerName, $debugMode = false)
    {
        $debug = '';
        $alertType = $return_value['return_value'] !== 0 ? 'error' : 'success';
        $msgString = '%s Label No. <strong>%s</strong> has been';
        $msgString .= ' sent to <strong>%s</strong>';

        if ($debugMode) {
            $debug = "<strong>IN DEBUG MODE: </strong>";
            $debug .= $alertType === 'error' ? $return_value['stderr'] : "";
        }

        return [
            'type' => $alertType,
            'msg' => sprintf($msgString, $debug, $pallet_ref, $printerName)
        ];
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
        if ($this->id && isset($this->data['Label']['qty'])) {
            $qty_before = $this->old['Label']['qty'];
            $qty_now = $this->data['Label']['qty'];
            return $qty_before !== $qty_now;
        }

        return false;
    }

    public function updateQtyPreviousWhenQtyChange()
    {
        /* if value of qty has changed log it */

        if ($this->hasQtyChanged()) {

            $qty_before = $this->old['Label']['qty'];

            $this->data['Label']['qty_previous'] = $qty_before;
            $this->data['Label']['qty_modified'] = $this->getDateTimeStamp();

        } else {
            unset($this->data['Label']['qty_user_id']);
        }
    }

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
     * @param type $options
     */
    public function beforeSave($options = [])
    {

        $this->changeCooldownAndStatusIfAddingCartons($this->data);

        $this->setDaysLife();

        $this->updateQtyPreviousWhenQtyChange();

        if ($this->id) {
            $this->recursive = -1;
            $this->old = $this->findById($this->data[$this->alias]['id']);
        }

        $this->updateInventoryStatusDateTime();
        $this->updateHasRecordChanged();

        $this->updateQtyPreviousWhenQtyChange();
    }

    /**
     * @param $sndata
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

    /* no longer used
     * added the donot_ship to the SQL virtual fields
     */

    /**
     * @param $lookup
     * @return mixed
     */
    public function doNotShip($lookup)
    {
        if ($lookup['Label']['shipment_id'] != 0) {
            return false;
        }

        //defaults to global
        $compare_days = $lookup['Label']['min_days_life'];

        $ship_low_date = $lookup['Label']['ship_low_date'];

        $fmt = 'd/m/y';
        $bb_date = $lookup['Label']['best_before'];
        $cur_date = date('Y-m-d');

        $date1 = DateTime::createFromFormat($fmt, $bb_date);

        $date2 = new DateTime($cur_date);

        $diff = $date2->diff($date1)->format("%r%a");

        return $diff < $compare_days;
    }

    /**
     * @var array
     */
    public $virtualFields = [
        'code_desc' => 'CONCAT( Label.pl_ref, ": ", Label.item, " - " , Label.description)',
        'best_before' => 'DATE_FORMAT(Label.bb_date, "%d/%m/%y")',
        'name' => 'CONCAT( Label.item, " " , Label.description, " " , Label.pl_ref)',
        'sscc_fmt' => 'CONCAT( LEFT(Label.sscc,1) , " ", MID(Label.sscc, 2,7) , " ", MID(Label.sscc,9,9) , " ",  RIGHT(Label.sscc,1) )',
        'dont_ship' => 'DATEDIFF(Label.bb_date, CURDATE()) < Label.min_days_life AND Label.shipment_id = 0'
    ];
    /**
     * @var string
     */
    public $displayField = 'name';

    /**
     * @param $term
     * @return mixed
     */
    public function palletReferenceLookup($term)
    {

        $cond = ['Label.pl_ref LIKE' => '%' . $term . '%'];

        $options = [
            'fields' => [
                'Label.pl_ref',
                'Label.code_desc'
            ],
            'conditions' => [
                'Label.pl_ref IS NOT NULL',
                'Label.pl_ref !=' => '',
                $cond
            ],
            'order' =>
            [
                'Label.pl_ref' => 'ASC'
            ]
        ];
        $pl_ref = $this->find('all', $options);

        $pl_refs = Hash::map($pl_ref, '{n}.Label', [$this, 'formatLookup']);

        return $pl_refs;
    }

    /**
     * @param $productTypeId
     * @return mixed
     */
    public function getAvailableLocations($filter, $productTypeId)
    {
        $options = $this->locationSpaceUsageOptions($filter, $productTypeId);

        $available = $this->find('all', $options);

        $availableLocations = Hash::combine($available, '{n}.Label.LocationId', '{n}.Label.Location', $groupPath = null);

        return $availableLocations;
    }

    /**
     * @param $locationId
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
     * @param array $extraOptions some more conditions to add to $options array
     * @return array returns an option array configured correctly to find location availability
     */
    public function locationSpaceUsageOptions($filter, $productTypeId = 'all', $extraOptions = [])
    {

        $this->virtualFields['Pallets'] = 'COUNT(Label.id)';
        $this->virtualFields['hasSpace'] = 'COUNT(Label.id) < Location.pallet_capacity';
        $this->virtualFields['LocationId'] = 'Location.id';
        $this->virtualFields['pallet_capacity'] = 'Location.pallet_capacity';
        $this->virtualFields['Location'] = 'Location.location';

        $options = [
            'recursive' => -1,
            'fields' => [
                'COUNT(Label.id) AS Label__Pallets',
                'COUNT(Label.id) < Location.pallet_capacity as Label__hasSpace',
                'Location.id  AS Label__LocationId',
                'Location.pallet_capacity AS Label__pallet_capacity',
                'Location.location AS Label__Location'
            ],
            'joins' => [
                [
                    'table' => 'shipments',
                    'alias' => 'Shipment',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Label.shipment_id = Shipment.id',
                        'Shipment.shipped' => 0
                    ]
                ],
                [
                    'table' => 'locations',
                    'alias' => 'Location',
                    'type' => 'RIGHT',
                    'conditions' => [
                        '( 	Label.location_id = Location.id AND
							Label.location_id <> 0 AND
							Label.inventory_status_id <> 2 AND
							Label.picked <> true ) AND
						(
							( Label.shipment_id = 0 ) OR
							( Label.shipment_id <> 0 AND Shipment.shipped IS NOT NULL))'
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
                'Location.pallet_capacity > COUNT(Label.id)'
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
     * @param $check
     * @return mixed
     */
    public function hasCapacityInLocation($check)
    {

        $locationId = $check['location_id'];

        // skip validation if the edit is not a move
        if (
            isset($this->data['Label']['previousLocationId']) &&
            !empty($this->data['Label']['previousLocationId']
            ) && $locationId === $this->data['Label']['previousLocationId']
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
                    'Label.shipment_id = Shipment.id'
                ]]
            ],
            'conditions' => [
                'OR' => [
                    [
                        'Label.location_id' => $locationId,
                        'Label.shipment_id' => 0,
                        'Label.inventory_status_id <> 2'
                    ],
                    [
                        'Label.location_id' => $locationId,
                        'Label.shipment_id <> 0',
                        'Label.picked = 0',
                        'Shipment.shipped = 0',
                        'Label.inventory_status_id <> 2'
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
     * @param $term
     * @return mixed
     */
    public function batchLookup($term)
    {
        $options = [
            'fields' => [
                'DISTINCT(Label.batch) as batch',
                'Label.print_date'
            ],
            'conditions' => [
                'Label.batch LIKE' => '%' . $term . '%'
            ],
            'group' => [
                'Label.batch'
            ],
            'recursive' => -1
        ];

        $batches = $this->find('all', $options);

        $batches = Hash::map($batches, '{n}.Label', [$this, 'formatBatch']);

        return $batches;
    }

    /**
     * @param $data
     */
    public function formatBatch($data)
    {
        return [
            'value' => $data['batch'],
            'label' => $data['batch'] . " - " . CakeTime::format($data['print_date'], '%a %d/%m/%Y', 'invalid')
        ];
    }

    /**
     * @param $pl_data
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
                'rule' => [ 'maxLength', 19 ],
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
