<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Lib\PrintLabels\Glabel\GlabelsProject;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

/**
 * PrintLog Model
 *
 * @method \App\Model\Entity\PrintLog newEmptyEntity()
 * @method \App\Model\Entity\PrintLog newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PrintLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PrintLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\PrintLog findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PrintLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PrintLog[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PrintLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrintLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrintLog[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintLog[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintLog[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintLog[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PrintLogTable extends Table
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

        $this->setTable('print_log');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TgnUtils');
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
            ->scalar('print_data')
            ->allowEmptyString('print_data');

        $validator
            ->scalar('controller_action')
            ->maxLength('controller_action', 100)
            ->allowEmptyString('controller_action');

        return $validator;
    }

    /**
     * getGlabelsDetail
     *
     * @param  string                                     $controller controller name
     * @param  string                                     $action     action name
     * @return \App\Lib\PrintLabels\Glabel\GlabelsProject
     */
    public function getGlabelsProject($controllerAction): GlabelsProject
    {
        $glabelsTemplate = TableRegistry::get('PrintTemplates')->find()
            ->where([
                'controller_action' => $controllerAction,
                'active' => 1,
            ])->first();

        $glabelsRoot = $this->getSetting('GLABELS_ROOT');

        return new GlabelsProject($glabelsTemplate, $glabelsRoot);
    }

    /**
     * create sequence list as needed in a list e.g.
     * [ "1" => "1", "2" => "2" ]
     *
     * @param  int   $max          high value
     * @param  int   $start        low value
     * @param  array $extraOptions values to add after high
     * @return array
     */
    public function createSequenceList($max, $start = 1, $extraOptions = [])
    {
        $sequence = [];
        for ($i = 1; $i <= $max; $i++) {
            $sequence[$i] = $i;
        }

        foreach ($extraOptions as $option) {
            if ($option > $max) {
                $sequence[$option] = $option;
            }
        }

        return $sequence;
    }

    /**
     * form print log data for print_log table
     * @param  string $controller_action result of $this->request->action or calling action
     * @param  array  $print_data        print data to encode as json
     * @return array
     */
    public function formatPrintLogData($controller_action, $print_data)
    {
        if (empty($controller_action) || empty($print_data)) {
            throw new NotFoundException('Failed to specify a controller_action and print_data');
        }

        return [
            'print_data' => json_encode($print_data),
            'controller_action' => $controller_action,
        ];
    }

    public function getControllerAction($request)
    {
        return $request->getParam('controller') . '::' . $request->getParam('action');
    }
}