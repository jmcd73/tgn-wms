<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace App\Policy;

use Authorization\IdentityInterface;
use CakeDC\Auth\Policy\SuperuserPolicy as CakedcSuperuserPolicy;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RequestPolicy
 *
 * @package CakeDC\Auth\Policy
 */
class SuperuserPolicy extends CakedcSuperuserPolicy
{
    /**
     * Check permission
     *
     * @param \Authorization\IdentityInterface|null    $identity user identity
     * @param \Psr\Http\Message\ServerRequestInterface $resource server request
     *
     * @return bool
     */
    public function canAccess(?IdentityInterface $identity, ServerRequestInterface $resource): bool
    {
        $user = $identity ? $identity->getOriginalData() : [];
        $superuserField = $this->getConfig('superuser_field');

        $isSuperUser = $user[$superuserField] ?? false;

        return $isSuperUser === true;
    }
}