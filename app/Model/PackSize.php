<?php
App::uses('AppModel', 'Model');
/**
 * PackSize Model
 *
 * @property Item $Item
 * @property MachinesStandardRate $MachinesStandardRate
 */
class PackSize extends AppModel {


/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'pack_size';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = [
		'pack_size' => [
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
				'message' => "This value already exists. Please enter a different value"
			]
		],
	];

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Item' => [
			'className' => 'Item',
			'foreignKey' => 'pack_size_id',
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
