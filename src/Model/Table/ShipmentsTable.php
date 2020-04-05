<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Shipments Model
 *
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\HasMany $Pallets
 *
 * @method \App\Model\Entity\Shipment newEmptyEntity()
 * @method \App\Model\Entity\Shipment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Shipment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shipment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Shipment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Shipment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Shipment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shipment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shipment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shipment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Shipment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Shipment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Shipment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShipmentsTable extends Table
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

        $this->setTable('shipments');
        $this->setDisplayField('shipper');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
        ]);

        $this->hasMany('Pallets', [
            'foreignKey' => 'shipment_id',
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
            ->scalar('shipper')
            ->maxLength('shipper', 30)
            ->requirePresence('shipper', 'create')
            ->notEmptyString('shipper');

        $validator
            ->scalar('con_note')
            ->maxLength('con_note', 50)
            ->requirePresence('con_note', 'create')
            ->notEmptyString('con_note');

        $validator
            ->scalar('shipment_type')
            ->maxLength('shipment_type', 20)
            ->requirePresence('shipment_type', 'create')
            ->notEmptyString('shipment_type');

        $validator
            ->scalar('destination')
            ->maxLength('destination', 250)
            ->requirePresence('destination', 'create')
            ->notEmptyString('destination');

        $validator
            ->integer('pallet_count')
            ->requirePresence('pallet_count', 'create')
            ->notEmptyString('pallet_count');

        $validator
            ->boolean('shipped')
            ->requirePresence('shipped', 'create')
            ->notEmptyString('shipped');

        $validator
            ->dateTime('time_start')
            ->allowEmptyDateTime('time_start');

        $validator
            ->dateTime('time_finish')
            ->allowEmptyDateTime('time_finish');

        $validator
            ->integer('time_total')
            ->allowEmptyString('time_total');

        $validator
            ->integer('truck_temp')
            ->allowEmptyString('truck_temp');

        $validator
            ->integer('dock_temp')
            ->allowEmptyString('dock_temp');

        $validator
            ->integer('product_temp')
            ->allowEmptyString('product_temp');

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
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));

        return $rules;
    }
}