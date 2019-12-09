<?php
App::uses('AppModel', 'Model');
/**
 * ProductType Model
 *
 * @property Item $Item
 * @property Location $Location
 * @property Shift $Shift
 */
class ProductType extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * getStorageTemperatureSelectOptions
     * Reads configure and returns an array
     * [ 'Ambient' => 'Ambient', 'Chilled' => 'Chilled' ]
     * @return array
     */
    public function getStorageTemperatureSelectOptions()
    {
        $storeTemps = Configure::read('StorageTemperatures');

        return array_combine($storeTemps, $storeTemps);
    }

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * @var array
     */
    public $belongsTo = [
        'DefaultLocation' => [
            'className' => 'Location',
            'foreignKey' => 'location_id'
        ],
        'InventoryStatus' => [
            'className' => "InventoryStatus",
            'foreignKey' => 'inventory_status_id'
        ]
    ];

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
        'ProductionLine' => [
            'className' => 'ProductionLine',
            'foreignKey' => 'product_type_id',
            'dependent' => false
        ],
        'Item' => [
            'className' => 'Item',
            'foreignKey' => 'product_type_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ],
        'Location' => [
            'className' => 'Location',
            'foreignKey' => 'product_type_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ],
        'Shift' => [
            'className' => 'Shift',
            'foreignKey' => 'product_type_id',
            'dependent' => false,
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
}