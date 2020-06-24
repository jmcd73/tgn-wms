<?php


namespace App\Error;

use Cake\Error\ExceptionRenderer;

class AppExceptionRenderer extends ExceptionRenderer
{
    public function missingConfigurationTest($error)
    {
        $response = $this->controller->getResponse();

        return $response->withStringBody('Oops that widget is missing.');
    }
}
