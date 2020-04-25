<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 *
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\HasMany $Pallets
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\HasMany $ProductTypes
 *
 * @method \App\Model\Entity\Location newEmptyEntity()
 * @method \App\Model\Entity\Location newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Location[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Location get($primaryKey, $options = [])
 * @method \App\Model\Entity\Location findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Location[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Location|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LocationsTable extends Table
{
    /**
     * Initialize method
     *
     * @param  array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('locations');
        $this->setDisplayField('location');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Pallets', [
            'foreignKey' => 'location_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param  \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('location')
            ->maxLength('location', 20)
            ->requirePresence('location', 'create')
            ->notEmptyString('location');

        $validator
            ->integer('pallet_capacity')
            ->requirePresence('pallet_capacity', 'create')
            ->notEmptyString('pallet_capacity');

        $validator
            ->boolean('is_hidden')
            ->requirePresence('is_hidden', 'create')
            ->notEmptyString('is_hidden');

        $validator
            ->scalar('description')
            ->maxLength('description', 50)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');
        $validator
            ->numeric('product_type_id')
            ->requirePresence('product_type_id', 'create')
            ->notEmpty('product_type_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param  \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));

        return $rules;
    }
}