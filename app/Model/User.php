<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';

    /**
     * beforeSave callback method
     * @param array $options options array
     * @return bool
     */
    public function beforeSave($options = [])
    {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }

        return true;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'username' => [
            'notBlank' => [
                'rule' => ['notBlank']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'isUnique' => [
                'rule' => 'isUnique',
                'message' => 'Username already exists! Please choose another or edit the existing one.'
            ]
        ],
        'password' => [
            'notBlank' => [
                'rule' => ['notBlank']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'role' => [
            'notBlank' => [
                'rule' => ['notBlank']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ]
    ];

    /**
     * @var array
     */
    public $hasMany = [
        'Pallet' => [
            'className' => 'Pallet',
            'foreignKey' => 'qty_user_id',
            'dependent' => false
        ]
    ];
}