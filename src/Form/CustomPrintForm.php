<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * CustomPrint Form.
 *
 */
class CustomPrintForm extends Form
{
    private $formName = '';
    private $copies = 20;

    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField($this->prependFormName() . 'copies', 'integer')
            ->addField($this->prependFormName() . 'printer', 'integer')
            ->addField($this->prependFormName() . 'name', 'string')
            ->addField('formName', 'string');
    }

    private function prependFormName()
    {
        if (!empty($this->formName) && is_string($this->formName)) {
            return $this->formName . '.';
        }
    }

    public function setCopies($copies)
    {
        if (is_numeric($copies)) {
            $this->copies = $copies;
        }
        return $this;
    }

    public function setFormName($name)
    {
        $this->formName = $name;
        return $this;
    }

    /**
    * Form validation builder
    *
    * @param \Cake\Validation\Validator $validator to use against the form
    * @return \Cake\Validation\Validator
    */
    public function validationDefault(Validator $validator):Validator
    {
        $fieldValidator = new Validator();
        $fieldValidator->notEmptyString('printer', 'Please select a printer')
        ->notEmptyString('copies', 'Copies cannot be empty')
        ->notBlank('copies', 'Please enter the copies')
        ->lessThan('copies', $this->copies, 'Less must be less than ' . $this->copies);

        $validator->addNested($this->formName, $fieldValidator);

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