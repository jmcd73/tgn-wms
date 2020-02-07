<?php
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');
/**
 * Shift Model
 *
 * @property ReportDate $ReportDate
 */
class Shift extends AppModel
{
    /**
     * beforeSave method
     * @param array $options options array
     * @return void
     */
    public function beforeSave($options = [])
    {
        parent::beforeSave($options);
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
        'shift_minutes' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        //                'start_time' => [
        //                        'checkTimes' => [
        //                            'rule' => [ 'checkStartStopTimes', 'stop_time'],
        //                            'message' => 'Start Time must be before Stop Time'
        //                        ]
        //                ],
        //                    'stop_time' => [
        //                        'checkTimes' => [
        //                            'rule' => [ 'checkStartStopTimes', 'start_time'],
        //                            'message' => 'Start Time must be before Stop Time'
        //                        ]
        //                ],

        'comment' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ],
    ];
}