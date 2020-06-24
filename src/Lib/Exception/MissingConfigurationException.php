<?php
declare(strict_types=1);

namespace App\Lib\Exception;

use Cake\Core\Exception\Exception;

class MissingConfigurationException extends Exception
{

    protected $_messageTemplate = '<strong>Missing configuration:</strong> %s is missing. %s';

    // You can set a default exception code as well.
    protected $_defaultCode = 404;

}

