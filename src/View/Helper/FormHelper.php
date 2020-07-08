<?php


namespace App\View\Helper;

use BootstrapUI\View\Helper\FormHelper as BootstrapUIFormHelper;

class FormHelper extends BootstrapUIFormHelper {

    protected function _dateTimeOptions(string $fieldName, array $options): array
    {
          
         if(isset($options['label']) && (bool) $options['label'] === false) {
            $options['templates']['label'] = "";
        } else {
            $options['label']['templateVars']['groupId'] =
            $options['templateVars']['groupId'] =
                $this->_domId($fieldName . '-group-label');
            $options['templates']['label'] = $this->templater()->get('datetimeLabel');
        }
        
        $options['templates']['inputContainer'] = $this->templater()->get('datetimeContainer');
        $options['templates']['inputContainerError'] = $this->templater()->get('datetimeContainerError');
   
        return $options;
    }
}