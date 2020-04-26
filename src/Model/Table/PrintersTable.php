<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Printers Model
 *
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\HasMany $Pallets
 * @property \App\Model\Table\ProductionLinesTable&\Cake\ORM\Association\HasMany $ProductionLines
 *
 * @method \App\Model\Entity\Printer newEmptyEntity()
 * @method \App\Model\Entity\Printer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Printer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Printer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Printer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Printer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Printer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Printer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Printer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PrintersTable extends Table
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

        $this->setTable('printers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Pallets', [
            'foreignKey' => 'printer_id',
        ]);
        $this->hasMany('ProductionLines', [
            'foreignKey' => 'printer_id',
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
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->allowEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('options')
            ->maxLength('options', 100)
            ->allowEmptyString('options');

        $validator
            ->scalar('queue_name')
            ->maxLength('queue_name', 45)
            ->allowEmptyString('queue_name');

        $validator
            ->scalar('set_as_default_on_these_actions')
            ->maxLength('set_as_default_on_these_actions', 2000)
            ->allowEmptyString('set_as_default_on_these_actions');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }

    public function getCupsURL($request)
    {
        $getEnv = getenv('CUPS_PORT');

        // if its not in a docker container then
        // return the default port
        $cupsPort = $getEnv === false ? 631 : $getEnv;

        // $request->is('ssl') ? 'https' : 'http';
        // scheme must be https to add printers
        $scheme = 'https';
        $host = $request->host();
        $hostPart = explode(':', $host)[0];

        return sprintf('%s://%s:%s', $scheme, $hostPart, $cupsPort);
    }
}