<?php

App::uses('AppModel', 'Model');

/**
 * InventoryStatus Model
 *
 * @property Pallet $Pallet
 */
class InventoryStatus extends AppModel
{
    /**
     * Use table
     *
     * @var mixed False or table name
     */

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * @return mixed
     */
    public function createStockViewPermsList()
    {
        $svp = Configure::read('StockViewPerms');
        foreach ($svp as $k => $v) {
            $new_array[$svp[$k]['value']] = Inflector::humanize($svp[$k]['display']);
        }

        return $new_array;
    }

    /**
     * @param array $results Array of results
     * @param bool $primary is being call from primary model
     * @return mixed
     */
    public function afterFind($results, $primary = false)
    {
        //parent::afterFind($results, $primary);

        foreach ($results as $key => $val) {
            if (isset($val['InventoryStatus']['perms'])) {
                $perms = Configure::read('StockViewPerms');
                foreach ($perms as $k => $perm) {
                    $results[$key]['InventoryStatus']['StockViewPerms'][$perm['value']] = $val['InventoryStatus']['perms'] & $perm['value'];
                }
            }
        }

        return $results;
    }

    /* this allows storing perms in one field */

    /**
     * @param array $options Options
     * @return void
     */
    public function beforeSave($options = [])
    {
        $perms = 0;

        if (!empty($this->data[$this->alias]['StockViewPerms'])) {
            $perms = array_sum($this->data[$this->alias]['StockViewPerms']);
        }
        $this->data[$this->alias]['perms'] = $perms;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'name' => [
            'isUnique' => [
                'rule' => ['isUnique'],
                'message' => 'Inventory status already exists. Please change',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
    ];

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
        'Pallet' => [
            'className' => 'Pallet',
            'foreignKey' => 'inventory_status_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ],
    ];
}