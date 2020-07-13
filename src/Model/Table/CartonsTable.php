<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Utility\Hash;

/**
 * Cartons Model
 *
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\BelongsTo $Pallets
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Carton newEmptyEntity()
 * @method \App\Model\Entity\Carton newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Carton[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Carton get($primaryKey, $options = [])
 * @method \App\Model\Entity\Carton findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Carton patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Carton[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Carton|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Carton saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Carton[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Carton[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Carton[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Carton[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\TgnUtilsBehavior
 */
class CartonsTable extends Table
{

    public function implementedEvents(): array
    {
            return [
                'Model.Cartons.addCartonRecord' => 'addCartonRecord'
            ];
    }

    public function addCartonRecord(Event $event)
    {

        $pallet = $event->getSubject();

        $fields = [
            'qty' => 'count',
            'production_date' => 'production_date',
            'bb_date' => 'best_before',
            'id' => 'pallet_id',
            'user_id' => 'user_id',
            'item_id' => 'item_id'
        ];

        $cartonRecord = [];

        foreach ($fields as $palletField => $cartonField) {
            $cartonRecord[$cartonField] = $pallet->get($palletField);
        }

        $carton = $this->newEntity($cartonRecord);

     

        if (!$this->save($carton)) {
            $errors  = $this->flattenAndFormatValidationErrors($carton->getErrors());
            throw new Exception(__('Could not save Carton record triggered by Model.Pallets.afterSave method {0}', $errors));
        }
    }


    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('cartons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('TgnUtils');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pallets', [
            'foreignKey' => 'pallet_id',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);

      
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('count')
            ->allowEmptyString('count');

        $validator
            ->date('best_before')
            ->allowEmptyDate('best_before');

        $validator
            ->date('production_date')
            ->allowEmptyDate('production_date');

        return $validator;
    }
    

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['pallet_id'], 'Pallets'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->isUnique(
            ['production_date', 'pallet_id'],
            'Cannot have two carton records with the same production date on this pallet'
        ));

        $rules->add($rules->isUnique(
            ['best_before', 'pallet_id'],
            'Cannot have two carton records with the same best before date on this pallet'
        ));

        return $rules;
    }

    public function processCartons($cartonData, $user)
    {
        $errorText = false;
        $update = array_filter($cartonData, function ($item) {
            return $item['count'] > 0 && $item['production_date'];
        });

        $delete = array_filter($cartonData, function ($item) {
            return $item['count'] == 0 && $item['id'] > 0;
        });
        
        $total = array_sum(Hash::extract($update, '{n}.count'));

        $deleteIds = Hash::extract($delete, '{n}.id');
        $updateIds = Hash::extract($update, '{n}.id');

        $deleteOK = false;
        $updateOK = false;

        if ($deleteIds) {
            if (
                $this->deleteAll(
                    [
                        'Carton.id IN' => $deleteIds,
                    ]
                )
            ) {
                $deleteOK = true;
            } else {
                $this->Flash->error('Delete Error');
            };
        }

        if ($update) {
            $entities = $this->find()->where(['id IN' => $updateIds]);
            foreach($update as $k => $v) {
                $update[$k]['user_id'] = $user->get('id');
            }
            $patched = $this->patchEntities($entities, $update);
        
            if ($this->saveMany($patched)) {
                $updateOK = true;
            } else {
                $validationErrors = [];

                foreach($patched as $k => $v) {
                    tog('v', $v);
                    $validationErrors = array_merge($validationErrors, $v->getErrors());
                }
                
                $errorText = $this->formatForSetErrors($validationErrors);
              
            };
        }

        return [ $total, $errorText ];
    }
}
