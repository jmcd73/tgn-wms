<?php
declare(strict_types=1);

namespace App\Policy;

use Authorization\IdentityInterface;
use CakeDC\Auth\Policy\PolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestPolicy implements PolicyInterface
{
    /**
     * Method to check if the request can be accessed
     *
     * @param  \Authorization\IdentityInterface|null $identity Identity
     * @param  \Cake\Http\ServerRequest              $request  Server Request
     * @return bool
     */
    public function canAccess(?IdentityInterface $identity, ServerRequestInterface $request): bool
    {
        if ($request->getParam('plugin') === 'DebugKit') {
            return true;
        }

        return false;
    }
}