<?php

App::uses('AppModel', 'Model');
/**
 * Location Model
 *
 * @property Label $Label
 */
class Location extends AppModel
{

    public $displayField = 'location';
    public $virtualFields = [
        'aisle' => 'SUBSTR(location, 2,1)',
        'column' => 'SUBSTR(location, 4,2)',
        'level' => 'SUBSTR(location, -2)',
    ];


/**
 * Validation rules
 *
 * @var array
 */
    public $validate = [
        'location' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'isUnique' => [
                'rule' => ['isUnique'],
                'message' => 'Location must be unique',
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
        'Label' => [
            'className' => 'Label',
            'foreignKey' => 'location_id',
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

    public $belongsTo = [
        'ProductType' => [
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ],
    ];

}
