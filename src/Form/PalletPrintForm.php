<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * PalletPrint Form.
 */
class PalletPrintForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('batch_no', 'string')
        ->addField('item', 'string')
        ->addField('production_line', 'string');
    }

    /*
      'batch_no' => [
                    'notBlank' => [
                        'rule' => 'notBlank',
                        'required' => true,
                        'message' => 'Please select a batch',
                    ], 'notInvalid' => [
                        'rule' => ['checkBatchNum'],
                        'message' => 'Select a batch number allocated to today',
                    ],
                ],
                'item' => [
                    'rule' => 'notBlank',
                    'required' => true,
                    'message' => 'Item cannot be empty',
                ],
                'production_line' => [
                    'rule' => 'notBlank',
                    'required' => true,
                    'message' => 'Production line is required',
                ],
    */

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator):Validator
    {
        $validator
        ->notBlank('batch_no', 'Please select a batch')
        ->requirePresence('batch_no', 'Please select a batch')
        ->notEmptyString('batch_no', 'Please select a batch')
        ->notBlank('item', 'Please select an Item')
        ->requirePresence('item', 'Please select an Item')
        ->notBlank('production_line', 'Please select a production line')
        ->requirePresence('production_line', true, 'Please select a production line');

        return $validator;
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        return true;
    }
}