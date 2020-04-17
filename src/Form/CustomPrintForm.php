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
     * @param  \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema
            ->addField($this->prependFormName() . 'printer', 'integer')
            ->addField($this->prependFormName() . 'copies', 'integer');
    }

    private function prependFormName()
    {
        if (!empty($this->formName) && is_string($this->formName)) {
            return $this->formName . '-';
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
     * @param  \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator):Validator
    {
        //$fieldValidator = new Validator();
        $validator->notEmptyString($this->prependFormName() . 'printer', 'Please select a printer')
        ->notEmptyString($this->prependFormName() . 'copies', 'Copies cannot be empty')
        ->add(
            $this->prependFormName() . 'copies',
            'not-blank',
            [
                'rule' => 'notBlank',
                'message' => 'Please enter the copies',
            ]
        )
        ->lessThan($this->prependFormName() . 'copies', $this->copies, 'Copies must be less than ' . $this->copies);

        // $validator->addNested($this->formName, $fieldValidator);

        return $validator;
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param  array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        return true;
    }
}