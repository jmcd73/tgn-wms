<?php
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');
/**
 * Shift Model
 *
 * @property ReportDate $ReportDate
 */
class Shift extends AppModel {

//    function checkStartStopTimes($check, $otherField){
//
//        $start_time =  CakeTime::toUnix($this->data[$this->alias]['start_time']);
//        $stop_time =  CakeTime::toUnix($this->data[$this->alias]['stop_time']);
//
//
//        return $start_time < $stop_time;
//
//    }


    function beforeSave($options = []) {
        parent::beforeSave($options);
    }

    function shift_minutes($report_date_id) {


        $options = [
            'joins' => [
                [
                    'table' => 'report_dates',
                    'alias' => 'ReportDate',
                    'type' => 'INNER',
                    'conditions' =>
                        [
                            'ReportDate.shift_id = Shift.id'

                        ],

                ]
            ],
           'conditions' => [
                                      'ReportDate.id' => $report_date_id
           ],
            'fields' => [
                'Shift.shift_minutes'
            ]
        ];
        $shift_minutes = $this->find('first', $options);

//        array(
//	'Shift' => array(
//		'shift_minutes' => '720',
//		'id' => '1'
//	),

        return $shift_minutes['Shift']['shift_minutes'];
        //return $options;

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


          public $belongsTo = [
		'ProductType' => [
			'className' => 'ProductType',
			'foreignKey' => 'product_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
                    ]
            ];

}
