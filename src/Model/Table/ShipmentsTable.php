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
     * @param  array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shipments');
        $this->setDisplayField('shipper');
        $this->setPrimaryKey('id');
        $this->addBehavior('TgnUtils');

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
     * @param  \Cake\Validation\Validator $validator Validator instance.
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
            ->scalar('destination')
            ->maxLength('destination', 250)
            ->requirePresence('destination', 'create')
            ->notEmptyString('destination');

        $validator
            ->integer('pallet_count')
            ->allowEmptyString('pallet_count');

        $validator
            ->boolean('shipped')
            ->requirePresence('shipped', 'update')
            ->allowEmpty('shipped');

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
        $rules->add($rules->isUnique(['shipper'], 'Shipper number must be unique'));

        $rules->addDelete(function ($entity, $options) {
            return !$entity->shipped;
        }, 'cantDeleteShipped', [
            'errorField' => 'shipped',
            'message' => 'A shipment cannot be deleted when it is marked as shipped',
        ]);

        /* $rules->addUpdate(function ($entity, $options) {
            return $entity->shipped && $entity->isDirty('shipped');
        }, 'cantUpdate', [
            'errorField' => 'shipped',
            'message' => 'A shipment cannot be changed when it is marked as shipped',
        ]); */

        return $rules;
    }

    /**
     * getShipmentLabelOptions creates an options array for a find call
     * @param int $id            of shipment
     * @param int $productTypeId id of product type we lookup for
     *
     * @return array
     */
    public function getShipmentLabelOptions($id, $productTypeId)
    {
        $perms = $this->getViewPermNumber('view_in_shipments');

        // in english
        // select all pallets that have a blank inventory status
        // or allowed
        // and also the current shipment id or a blank ID.
        $options = [
            'conditions' => [
                'OR' => [
                    'InventoryStatuses.perms & ' . $perms,
                    'Pallets.inventory_status_id' => 0, // not on hold
                ],
                'AND' => [
                    'OR' => [
                        'Pallets.product_type_id' => $productTypeId,
                        'Pallets.shipment_id = ' . $id,
                    ],
                ],
                'NOT' => [
                    'Pallets.location_id' => 0, // has been put away
                ],
            ],
            'order' => [
                'FIELD ( Pallets.shipment_id,' . $id . ',0)',
                'Pallets.item' => 'ASC',
                'Pallets.pl_ref' => 'ASC',
            ],
            'contain' => [
                'Locations' => [
                    'fields' => ['Locations.id', 'Locations.location'],
                ],
                'InventoryStatuses',
            ],
        ];

        return $options;
    }
}