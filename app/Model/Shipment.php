<?php

App::uses('AppModel', 'Model');

/**
 * Shipment Model
 *
 * @property Pallet $Pallet
 */
class Shipment extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'shipper';

    /**
     * @var mixed $old Contains null or previous record
     */
    public $old = null;

    /**
     * getShipmentLabelOptions creates an options array for a find call
     * @param int $id of shipment
     * @param int $productTypeId id of product type we lookup for
     *
     * @return array
     */
    public function getShipmentLabelOptions($id, $productTypeId)
    {
        $perms = $this->getViewPermNumber('view_in_shipments');

        // in english
        // select all pallets that have a blank inventory status
        // or allowed
        // and also the current shipment id or a blank ID.
        $options = [
            'conditions' => [
                'OR' => [
                    'InventoryStatus.perms & ' . $perms,
                    'Pallet.inventory_status_id' => 0, // not on hold
                ],
                'AND' => [
                    'OR' => [
                        'Pallet.product_type_id' => $productTypeId,
                        'Pallet.shipment_id = ' . $id,
                    ],
                ],
                'NOT' => [
                    'Pallet.location_id' => 0, // has been put away
                ],
            ],
            'order' => [
                'FIELD ( Pallet.shipment_id,' . $id . ',0)',
                'Pallet.item' => 'ASC',
                'Pallet.pl_ref' => 'ASC',
            ],
            'contain' => [
                'Location' => [
                    'fields' => ['Location.id', 'Location.location'],
                ],
                'InventoryStatus',
            ],
        ];

        return $options;
    }

    /**
     * getShipmentLabels method
     * @param int $id shipment id
     * @param int $productTypeId Product type Id
     * @return mixed
     */
    public function getShipmentLabels($id, $productTypeId)
    {
        $options = $this->getShipmentLabelOptions($id, $productTypeId);

        return $this->Pallet->find('all', $options);
    }

    /**
     * labelCount count pallets
     * @param array $data data array of labels
     * @return int
     */
    public function labelCount($data)
    {
        return empty($data) ? 0 : count($data);
    }

    /**
     * isDifferentArrays
     * @param array $old Old array
     * @param array $now Now array
     * @return bool
     */
    public function isDifferentArrays($old = [], $now = [])
    {
        $now = $now === '' ? [] : $now;

        sort($now);
        sort($old);

        $diff = Hash::diff($now, $old);

        return (bool)count($diff);
    }

    /**
     * checkLabelsNotChanged validation method
     * @return bool
     */
    public function checkLabelsNotChanged()
    {
        if ($this->id && isset($this->data['Pallet'])) {
            // is an update
            $this->old = $this->findById($this->id);

            $labels_now = Hash::extract($this->data['Pallet'], '{n}.id');

            $labels_old = Hash::extract($this->old['Pallet'], '{n}.id');

            $old_shipped = $this->old[$this->alias]['shipped'];
            $new_shipped = $this->data[$this->alias]['shipped'];

            $changed = $this->isDifferentArrays($labels_old, $labels_now);

            return (!$old_shipped && !$new_shipped && $changed) ||
                (!$old_shipped && $new_shipped && !$changed) ||
                ($old_shipped && !$new_shipped && !$changed) ||
                ($old_shipped && $new_shipped && !$changed) ||
                (!$old_shipped && !$new_shipped && !$changed);
        }

        return true;
    }

    /**
     * destinationLookup
     * @param string $term snippet of destination to lookup from typeahead
     * @return array
     */
    public function destinationLookup($term)
    {
        $options = [
            'fields' => [
                'DISTINCT(Shipment.destination) as destination',
            ],
            'conditions' => [
                'Shipment.destination LIKE' => '%' . $term . '%',
            ],
            'recursive' => -1,
        ];

        $destinations = $this->find('all', $options);

        $destinations = Hash::map(
            $destinations,
            '{n}.Shipment',
            [
                $this, 'formatBatch',
            ]
        );

        return $destinations;
    }

    /**
     * @param array $data Data to format
     * @return array
     */
    public function formatBatch($data)
    {
        return [
            'value' => $data['destination'],
        ];
    }

    // gets shipment type based on shipment id

    /**
     * @param array $dataArray array of data
     * @return array
     */
    public function getIds($dataArray = [])
    {
        $ids = [];

        if (!empty($dataArray['Pallet'][0]['Pallet'])) {
            $ids = Hash::extract($dataArray['Pallet'], '{n}.Pallet.id');
        } elseif (!empty($dataArray['Pallet'][0]['id'])) {
            $ids = Hash::extract($dataArray['Pallet'], '{n}.id');
        } elseif (!empty($dataArray['Pallet'])) {
            $ids = $dataArray['Pallet'];
        }

        return $ids;
    }

    /**
     * @param array $shipment_labels Array of labels or pallets more correctly
     * @return array
     */
    public function formatLabels($shipment_labels)
    {
        return Hash::combine($shipment_labels, '{n}.Pallet.id', [
            '%s: %s, %s, %s, %s, %s',
            '{n}.Location.location',
            '{n}.Pallet.item',
            '{n}.Pallet.best_before',
            '{n}.Pallet.pl_ref',
            '{n}.Pallet.qty',
            '{n}.Pallet.description',
        ]);
    }

    /**
     * markDisabled creates and returns an array of items for the Form->input control to disable
     * @param array $shipment_labels array of pallets
     * @return array
     */
    public function markDisabled($shipment_labels = [])
    {
        foreach ($shipment_labels as $key => $ret) {
            if ($shipment_labels[$key]['Pallet']['dont_ship'] && !$shipment_labels[$key]['Pallet']['ship_low_date']) {
                $shipment_labels[$key]['Pallet']['disabled'] = true;
            } else {
                $shipment_labels[$key]['Pallet']['disabled'] = false;
            }
        }

        return $shipment_labels;
    }

    /*
     * creates and returns an array of items for the Form->input control to disable
     */

    /**
     * getDiabled creates and returns an array of items for the Form->input control to disable
     * @param array $values values to disable
     * @return array
     */
    public function getDisabled($values)
    {
        $disabled = [];

        foreach ($values as $ret) {
            if ($ret['Pallet']['dont_ship'] && !$ret['Pallet']['ship_low_date']) {
                $disabled[] = $ret['Pallet']['id'];
            }
        }

        return $disabled;
    }

    /**
     * @param mixed $var a value to check for empty
     * @return bool
     */
    public function isEmpty($var)
    {
        if (empty($var) && $var !== '' && intval($var) === 0) {
            return false;
        }
        if (empty($var)) {
            return true;
        }

        return false;
    }

    /**
     * noChangeOnceShipped validation method
     * @param array $check fieldname and value array to check
     * @return bool
     */
    public function noChangeOnceShipped($check)
    {
        if ($this->id) {
            $fieldName = array_keys($check)[0];

            $this->old = $this->findById($this->id);

            $old_shipped = $this->old[$this->alias]['shipped'];
            $new_shipped = $this->data[$this->alias]['shipped'];

            $old_value = $this->old[$this->alias][$fieldName];
            $new_value = $this->data[$this->alias][$fieldName];
            // OK ( $old_shipped === false ) && ( $new_shipped === true )
            // NOT OK ( $old_shipped === true ) && ( $new_shipped === false ) && ( $old_value !== $new_value )
            // OK ($old_shipped === true ) && ( $new_shipped === false ) && ( $old_value === $new_value )

            return (!$old_shipped && $new_shipped && ($old_value === $new_value)) ||
                (!$old_shipped && $new_shipped && ($old_value !== $new_value)) ||
                (!$old_shipped && !$new_shipped && ($old_value !== $new_value)) ||
                (!$old_shipped && !$new_shipped && ($old_value === $new_value)) ||
                ($old_shipped && !$new_shipped && ($old_value === $new_value)) ||
                ($old_shipped && $new_shipped && ($old_value === $new_value));
        }

        return true;
    }

    /**
     * checkPallets need pallets on a shipment to mark as shipped
     * @param array $check field to check
     *
     * @return bool
     */
    public function checkPallets($check)
    {
        if ((int)$check['shipped'] === 0) {
            // don't check if not shipping
            return true;
        }

        return (int)$check['shipped'] === 1 && (
            !empty($this->data['Shipment']['Pallet']) ||
            !empty($this->data['Pallet'])
        );
    }

    /**
     * @var array
     */
    public $validate = [
        'destination' => [
            'noChangeOnceShipped' => [
                'rule' => 'noChangeOnceShipped',
                'on' => 'update',
                'message' => "You can't change a shipment after marking it as shipped",
            ],
        ],
        'shipper' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'Shipper number cannot be blank',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'noChangeOnceShipped' => [
                'rule' => 'noChangeOnceShipped',
                'on' => 'update',
                'message' => "You can't change a shipment after marking it as shipped",
            ],
            'isUnique' => [
                'rule' => ['isUnique'],
                'message' => 'Shipment number must be unique',
            ],
        ],
        'shipped' => [
            'check_pallets' => [
                'rule' => 'checkPallets',
                'message' => 'At least one pallet is needed on a shipment',
            ],
            'no_add_to_shipped' => [
                'rule' => 'checkLabelsNotChanged',
                'on' => 'update',
                'message' => "You can't change a shipment after marking it as shipped",
            ],
        ],
    ];

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * @var array
     */
    public $belongsTo = [
        'ProductType' => [
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id',
            'dependent' => false,
        ],
    ];
    /**
     * @var array
     */
    public $hasMany = [
        'Pallet' => [
            'className' => 'Pallet',
            'foreignKey' => 'shipment_id',
            'dependent' => false,
        ],
    ];
}