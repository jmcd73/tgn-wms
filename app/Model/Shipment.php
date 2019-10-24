<?php

App::uses('AppModel', 'Model');

/**
 * Shipment Model
 *
 * @property Label $Label
 */
class Shipment extends AppModel
{
    /**
     * @var mixed $old Contains null or previous record
     */
    public $old = null;

    /**
     * Checks that no pallets have been added or removed
     *
     * @return boolean
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
                // not on hold
                'OR' => [
                    'InventoryStatus.perms & ' . $perms,
                    'Label.inventory_status_id' => 0
                ],
                'AND' => [
                    // not shipped or this shipper
                    'OR' => [
                        'Label.product_type_id' => $productTypeId,
                        'Label.shipment_id = ' . $id

                    ]
                ],
                // has been put away
                'NOT' => [
                    'Label.location_id' => 0
                ]],
            'order' => [
                'FIELD ( Label.shipment_id,' . $id . ',0)',
             //   "FIND_IN_SET( LEFT( Label.item, 1), " . "'" . $sh_sort . "')",
                'Label.item' => 'ASC',
                'Label.pl_ref' => 'ASC'
            ],
            'contain' => [

                'Location' => [
                    'fields' => ['Location.id', 'Location.location']
                ],
                'InventoryStatus'
            ]
        ];

        return $options;
    }

    /**
     * @param $id
     * @param $sh_sort
     * @return mixed
     */
    public function getShipmentLabels($id, $productTypeId)
    {
        $options = $this->getShipmentLabelOptions($id,  $productTypeId);

        return $this->Label->find('all', $options);

    }
    /**
     * @param $data
     */
    public function labelCount($data)
    {

        return empty($data) ? 0 : count($data);

    }

    /**
     * @param array $old
     * @param array $now
     */
    public function isDifferentArrays($old = [], $now = [])
    {

        $now = $now === '' ? [] : $now;

        sort($now);
        sort($old);

        $diff = Hash::diff($now, $old);

        return (bool) count($diff);

    }

    /**
     * @param $check
     */
    public function checkLabelsNotChanged($check)
    {

        if ($this->id && isset($this->data['Label'])) {

            // is an update
            $this->old = $this->findById($this->id);

            $labels_now = Hash::extract($this->data['Label'], '{n}.id');

            $labels_old = Hash::extract($this->old['Label'], '{n}.id');

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
     * @param $term
     * @return mixed
     */
    public function destinationLookup($term)
    {

        $options = [
            'fields' => [
                'DISTINCT(Shipment.destination) as destination'
            ],
            'conditions' => [
                'Shipment.destination LIKE' => '%' . $term . '%'
            ],
            'recursive' => -1
        ];

        $destinations = $this->find('all', $options);

        $destinations = Hash::map(
            $destinations,
            '{n}.Shipment',
            [
                $this, 'formatBatch'
            ]
        );
        return $destinations;
    }

    /**
     * @param $data
     */
    public function formatBatch($data)
    {

        return [
            'value' => $data['destination']
        ];

    }

    // gets shipment type based on shipment id


    /**
     * @param array $dataArray
     * @return mixed
     */
    public function getIds($dataArray = [])
    {
        $ids = [];

        if (!empty($dataArray['Label'][0]['Label'])) {
            $ids = Hash::extract($dataArray['Label'], '{n}.Label.id');
        } elseif (!empty($dataArray['Label'][0]['id'])) {
            $ids = Hash::extract($dataArray['Label'], '{n}.id');
        } elseif (!empty($dataArray['Label'])) {
            $ids = $dataArray['Label'];
        }

        return $ids;
    }

    /*
     * formats labels Bottling: 62001, 08/09/17, B0041386, 63, Coles Canola 4lt
     * [ id => "Location: Code, Date, pl ref, qty, description" ]
     */

    /**
     * @param $shipment_labels
     */
    public function formatLabels($shipment_labels)
    {
        return Hash::combine($shipment_labels, '{n}.Label.id', [
            '%s: %s, %s, %s, %s, %s',
            '{n}.Location.location',
            '{n}.Label.item',
            '{n}.Label.best_before',
            '{n}.Label.pl_ref',
            '{n}.Label.qty',
            '{n}.Label.description'
        ]);
    }

    /*
     * creates and returns an array of items for the Form->input control to disable
     */

    /**
     * @param array $shipment_labels
     * @return mixed
     */
    public function markDisabled($shipment_labels = [])
    {

        foreach ($shipment_labels as $key => $ret) {

            if ($shipment_labels[$key]['Label']['dont_ship'] && !$shipment_labels[$key]['Label']['ship_low_date']) {
                $shipment_labels[$key]['Label']['disabled'] = true;
            } else {
                $shipment_labels[$key]['Label']['disabled'] = false;
            }
        }

        return $shipment_labels;
    }

    /*
     * creates and returns an array of items for the Form->input control to disable
     */

    /**
     * @param $values
     * @return mixed
     */
    public function getDisabled($values)
    {

        $disabled = [];

        foreach ($values as $ret) {

            if ($ret['Label']['dont_ship'] && !$ret['Label']['ship_low_date']) {
                $disabled[] = $ret['Label']['id'];
            }
        }

        return $disabled;
    }

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'shipper';

    // define shipment type based on label ids

    /**
     * @param array $ids
     * @return mixed
     */
    public function getShipmentTypeByLabelIds($ids = [])
    {

        $labels = $this->Label->find(
            'all', [
                'conditions' => [
                    'Label.id' => $ids
                ],
                'fields' => [
                    'LEFT(Label.item, 1) as code_start'
                ]
            ]
        );
        return $this->compareShipmentTypes($labels);
    }

    // gets shipment type based on shipment id



    // takes an array of the first digit of labels e.g. [ 5, 6]
    // and checks to see if the array matches
    // oil [ 6 ], marg [ 5 ] or mixed [ 5, 6 ]
    // and returns the string type either oil, marg, mixed or unknown (if labels is null)

    /**
     * @param $labels
     * @return mixed
     */
    public function compareShipmentTypes($labels = null)
    {

        $shipment_types = Configure::read('ShipmentTypes');

        if ($labels === null) {
            return $shipment_types['unknown']['type'];
        }

        $code_start = Hash::extract($labels, '{n}.{n}.code_start');

        $codes = array_values(array_unique($code_start));

        sort($codes);

        foreach ($shipment_types as $k => $t) {
            sort($t['values']);

            if ($t['values'] == $codes) {
                return $t['type'];
            }
        }
    }

    /**
     * @param $var
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
     * @param $check
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
     * CheckPallets need pallets on a shipment to mark as shipped
     * @param string $check field to check
     *
     * @return bool
     */
    public function checkPallets($check)
    {

        if ((int) $check['shipped'] === 0) {
            // don't check if not shipping
            return true;
        }

        return (int) $check['shipped'] === 1 && (
            !empty($this->data['Shipment']['Label']) ||
            !empty($this->data['Label'])
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
                'message' => "You can't change a shipment after marking it as shipped"
            ]
        ],
        'shipper' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'Shipper number cannot be blank'
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'noChangeOnceShipped' => [
                'rule' => 'noChangeOnceShipped',
                'on' => 'update',
                'message' => "You can't change a shipment after marking it as shipped"
            ],
            'isUnique' => [
                'rule' => ['isUnique'],
                'message' => 'Shipment number must be unique'
            ]
        ],
        'shipped' => [
            'check_pallets' => [
                'rule' => 'checkPallets',
                'message' => 'At least one pallet is needed on a shipment'
            ],
            'no_add_to_shipped' => [
                'rule' => 'checkLabelsNotChanged',
                'on' => 'update',
                'message' => "You can't change a shipment after marking it as shipped"
            ]
        ]
    ];

    //The Associations below have been created with all possible keys, those that are not needed can be removed

     /**
     * @var array
     */
    public $belongsTo = [
        'ProductType' => [
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id',
            'dependent' => false
        ]
    ];
    /**
     * @var array
     */
    public $hasMany = [
        'Label' => [
            'className' => 'Label',
            'foreignKey' => 'shipment_id',
            'dependent' => false
        ]
    ];
}
