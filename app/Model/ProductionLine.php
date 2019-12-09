<?php
App::uses('AppModel', 'Model');
/**
 * ProductionLine Model
 *
 * @property ProductType $ProductType
 */
class ProductionLine extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    // The Associations below have been created with all possible keys, those that are not needed can be removed

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
        ]

    ];
}