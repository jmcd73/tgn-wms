<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * OnhandSearch Form.
 */
class OnhandSearchForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('filter_value', 'string');
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator): Validator
    {
        return $validator;
    }

    /**
    * Form validation builder
    *
    * @param \Cake\Validation\Validator $validator to use against the form
    * @return \Cake\Validation\Validator
    */
    public function validationDefault(Validator $validator):Validator
    {
        $validator->allowEmptyString('filter_value', 'Please select a search value');

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