<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * InventoryStatuses Model
 *
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\HasMany $Pallets
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\HasMany $ProductTypes
 *
 * @method \App\Model\Entity\InventoryStatus newEmptyEntity()
 * @method \App\Model\Entity\InventoryStatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\InventoryStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InventoryStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventoryStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventoryStatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InventoryStatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\InventoryStatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InventoryStatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class InventoryStatusesTable extends Table
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

        $this->setTable('inventory_statuses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Pallets', [
            'foreignKey' => 'inventory_status_id',
        ]);
        $this->hasMany('ProductTypes', [
            'foreignKey' => 'inventory_status_id',
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
            ->requirePresence('perms', 'create')
            ->allowEmptyArray('perms');

        $validator
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 255)
            ->requirePresence('comment', 'create')
            ->notEmptyString('comment');

        $validator
            ->boolean('allow_bulk_status_change')
            ->allowEmptyString('allow_bulk_status_change');

        return $validator;
    }

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * @return mixed
     */
    public function createStockViewPermsList()
    {
        $stockViewPerms = Configure::read('StockViewPerms');

        /*  foreach ($stockViewPerms as $k => $v) {
             $new_array[$stockViewPerms[$k]['value']] = Inflector::humanize($stockViewPerms[$k]['display']);
         } */

        return Hash::combine($stockViewPerms, '{n}.value', '{n}.display');
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if (is_array($entity->perms)) {
            $entity->perms = array_sum($entity->perms);
        }

        return $entity;
    }
}