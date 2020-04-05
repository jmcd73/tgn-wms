<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductTypes Model
 *
 * @property \App\Model\Table\InventoryStatusesTable&\Cake\ORM\Association\BelongsTo $InventoryStatuses
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\HasMany $Locations
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\HasMany $Pallets
 * @property \App\Model\Table\ProductionLinesTable&\Cake\ORM\Association\HasMany $ProductionLines
 * @property \App\Model\Table\ShiftsTable&\Cake\ORM\Association\HasMany $Shifts
 * @property \App\Model\Table\ShipmentsTable&\Cake\ORM\Association\HasMany $Shipments
 *
 * @method \App\Model\Entity\ProductType newEmptyEntity()
 * @method \App\Model\Entity\ProductType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ProductType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ProductType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductType[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductType[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductType[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductType[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductTypesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('product_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('InventoryStatuses', [
            'foreignKey' => 'inventory_status_id',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'product_type_id',
        ]);
        $this->hasMany('Locations', [
            'foreignKey' => 'product_type_id',
        ]);
        $this->hasMany('Pallets', [
            'foreignKey' => 'product_type_id',
        ]);
        $this->hasMany('ProductionLines', [
            'foreignKey' => 'product_type_id',
        ]);
        $this->hasMany('Shifts', [
            'foreignKey' => 'product_type_id',
        ]);
        $this->hasMany('Shipments', [
            'foreignKey' => 'product_type_id',
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
            ->scalar('name')
            ->maxLength('name', 20)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code_prefix')
            ->maxLength('code_prefix', 20)
            ->requirePresence('code_prefix', 'create')
            ->notEmptyString('code_prefix');

        $validator
            ->scalar('storage_temperature')
            ->maxLength('storage_temperature', 20)
            ->requirePresence('storage_temperature', 'create')
            ->notEmptyString('storage_temperature');

        $validator
            ->scalar('code_regex')
            ->maxLength('code_regex', 45)
            ->requirePresence('code_regex', 'create')
            ->notEmptyString('code_regex');

        $validator
            ->scalar('code_regex_description')
            ->maxLength('code_regex_description', 100)
            ->requirePresence('code_regex_description', 'create')
            ->notEmptyString('code_regex_description');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->integer('next_serial_number')
            ->allowEmptyString('next_serial_number');

        $validator
            ->scalar('serial_number_format')
            ->maxLength('serial_number_format', 45)
            ->allowEmptyString('serial_number_format');

        $validator
            ->boolean('enable_pick_app')
            ->allowEmptyString('enable_pick_app');

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
        $rules->add($rules->existsIn(['inventory_status_id'], 'InventoryStatuses'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));

        return $rules;
    }
}