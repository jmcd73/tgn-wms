<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Labels Model
 *
 * @property \App\Model\Table\ProductionLinesTable&\Cake\ORM\Association\BelongsTo $ProductionLines
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\PrintersTable&\Cake\ORM\Association\BelongsTo $Printers
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ShipmentsTable&\Cake\ORM\Association\BelongsTo $Shipments
 * @property \App\Model\Table\InventoryStatusesTable&\Cake\ORM\Association\BelongsTo $InventoryStatuses
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\BelongsTo $ProductTypes
 *
 * @method \App\Model\Entity\Label newEmptyEntity()
 * @method \App\Model\Entity\Label newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Label[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Label get($primaryKey, $options = [])
 * @method \App\Model\Entity\Label findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Label patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Label[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Label|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Label saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Label[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Label[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Label[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Label[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LabelsTable extends Table
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

        $this->setTable('labels');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductionLines', [
            'foreignKey' => 'production_line_id',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Printers', [
            'foreignKey' => 'printer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Shipments', [
            'foreignKey' => 'shipment_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('InventoryStatuses', [
            'foreignKey' => 'inventory_status_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ProductTypes', [
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
            ->scalar('item')
            ->maxLength('item', 10)
            ->requirePresence('item', 'create')
            ->notEmptyString('item');

        $validator
            ->scalar('description')
            ->maxLength('description', 50)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('best_before')
            ->maxLength('best_before', 10)
            ->requirePresence('best_before', 'create')
            ->notEmptyString('best_before');

        $validator
            ->date('bb_date')
            ->requirePresence('bb_date', 'create')
            ->notEmptyDate('bb_date');

        $validator
            ->scalar('gtin14')
            ->maxLength('gtin14', 14)
            ->requirePresence('gtin14', 'create')
            ->notEmptyString('gtin14');

        $validator
            ->integer('qty')
            ->requirePresence('qty', 'create')
            ->notEmptyString('qty');

        $validator
            ->scalar('qty_previous')
            ->maxLength('qty_previous', 255)
            ->requirePresence('qty_previous', 'create')
            ->notEmptyString('qty_previous');

        $validator
            ->dateTime('qty_modified')
            ->requirePresence('qty_modified', 'create')
            ->notEmptyDateTime('qty_modified');

        $validator
            ->scalar('pl_ref')
            ->maxLength('pl_ref', 20)
            ->requirePresence('pl_ref', 'create')
            ->notEmptyString('pl_ref')
            ->add('pl_ref', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('sscc')
            ->maxLength('sscc', 18)
            ->requirePresence('sscc', 'create')
            ->notEmptyString('sscc')
            ->add('sscc', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('batch')
            ->maxLength('batch', 6)
            ->requirePresence('batch', 'create')
            ->notEmptyString('batch');

        $validator
            ->dateTime('print_date')
            ->requirePresence('print_date', 'create')
            ->notEmptyDateTime('print_date');

        $validator
            ->dateTime('cooldown_date')
            ->allowEmptyDateTime('cooldown_date');

        $validator
            ->integer('min_days_life')
            ->requirePresence('min_days_life', 'create')
            ->notEmptyString('min_days_life');

        $validator
            ->scalar('production_line')
            ->maxLength('production_line', 45)
            ->requirePresence('production_line', 'create')
            ->notEmptyString('production_line');

        $validator
            ->scalar('inventory_status_note')
            ->maxLength('inventory_status_note', 100)
            ->requirePresence('inventory_status_note', 'create')
            ->notEmptyString('inventory_status_note');

        $validator
            ->dateTime('inventory_status_datetime')
            ->requirePresence('inventory_status_datetime', 'create')
            ->notEmptyDateTime('inventory_status_datetime');

        $validator
            ->boolean('ship_low_date')
            ->requirePresence('ship_low_date', 'create')
            ->notEmptyString('ship_low_date');

        $validator
            ->boolean('picked')
            ->requirePresence('picked', 'create')
            ->notEmptyString('picked');

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
        $rules->add($rules->isUnique(['pl_ref']));
        $rules->add($rules->isUnique(['sscc']));
        $rules->add($rules->existsIn(['production_line_id'], 'ProductionLines'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['printer_id'], 'Printers'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['shipment_id'], 'Shipments'));
        $rules->add($rules->existsIn(['inventory_status_id'], 'InventoryStatuses'));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));

        return $rules;
    }
}