<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductionLines Model
 *
 * @property \App\Model\Table\PrintersTable&\Cake\ORM\Association\BelongsTo $Printers
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\HasMany $Pallets
 *
 * @method \App\Model\Entity\ProductionLine newEmptyEntity()
 * @method \App\Model\Entity\ProductionLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ProductionLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductionLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductionLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ProductionLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductionLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductionLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductionLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductionLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductionLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductionLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductionLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductionLinesTable extends Table
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

        $this->setTable('production_lines');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Printers', [
            'foreignKey' => 'printer_id',
        ]);
        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
        ]);

        $this->hasMany('Pallets', [
            'foreignKey' => 'production_line_id',
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
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->allowEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['printer_id'], 'Printers'));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));

        return $rules;
    }
}