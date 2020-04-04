<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * CustomPrint Form.
 */
class CustomPrintForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('copies', 'integer')->addField('printer', 'integer');
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
        $validator->notBlank('printer', 'Please select a printer')
        ->notBlank('copies', 'Item cannot be empty');

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