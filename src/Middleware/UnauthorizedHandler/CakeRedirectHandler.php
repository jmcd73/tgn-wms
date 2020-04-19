<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Middleware\UnauthorizedHandler;

use Authorization\Exception\Exception;
use Authorization\Exception\ForbiddenException;
use Authorization\Exception\MissingIdentityException;
use Authorization\Middleware\UnauthorizedHandler\CakeRedirectHandler as CakedcCakeRedirectHandler;
use Cake\Http\Response;
use Cake\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

/**
 * This handler will redirect the response if one of configured exception classes is encountered.
 *
 * CakePHP Router compatible array URL syntax is supported.
 */
class CakeRedirectHandler extends CakedcCakeRedirectHandler
{
    /**
     * @inheritDoc
     */
    protected $defaultOptions = [
        'exceptions' => [
            MissingIdentityException::class,
            //  MissingIdentityException::class,
            // ForbiddenException::class,
            //
        ],
        'url' => [
            'controller' => 'Users',
            'action' => 'login',
        ],
        'queryParam' => 'redirect',
        'statusCode' => 302,
    ];

    /**
     * Constructor.
     *
     * @throws \RuntimeException When `Cake\Routing\Router` class cannot be found.
     */
    public function __construct()
    {
        if (!class_exists(Router::class)) {
            $message = sprintf(
                'Class `%s` does not exist. ' .
                'Make sure you are using a full CakePHP framework ' .
                'and have autoloading configured properly.',
                Router::class
            );
            throw new RuntimeException($message);
        }
    }

    /**
     * @inheritDoc
     */
    protected function getUrl(ServerRequestInterface $request, array $options): string
    {
        $url = $options['url'];
        if ($options['queryParam'] !== null) {
            $uri = $request->getUri();
            $redirect = $uri->getPath();
            if ($uri->getQuery()) {
                $redirect .= '?' . $uri->getQuery();
            }

            $url['?'][$options['queryParam']] = $redirect;
        }

        return Router::url($url);
    }

    /**
     * Return a response with a location header set if an exception matches.
     *
     * @inheritDoc
     */
    public function handle(
        Exception $exception,
        ServerRequestInterface $request,
        array $options = []
    ): ResponseInterface {
        $options += $this->defaultOptions;

        if (!$this->checkException($exception, $options['exceptions'])) {
            throw $exception;
        }

        // tog('AUTHJM', $request->getAttribute('authentication')->getIdentity());

        $options = $this->customRedirect($exception, $request, $options);

        $url = $this->getUrl($request, $options);

        $response = new Response();

        return $response
            ->withHeader('Location', $url)
            ->withStatus($options['statusCode']);
    }

    public function customRedirect(
        $exception,
        $request,
        $options
    ) {
        foreach ($options['customUrlMap'] as $class => $url) {
            if ($exception instanceof $class && $request->getAttribute('authentication')->getIdentity() !== null) {
                $options['url'] = $url;

                return $options;
            }
        }

        return $options;
    }

    /**
     * Checks if an exception matches one of the classes.
     *
     * @param  \Authorization\Exception\Exception $exception  Exception instance.
     * @param  \Exception[]                       $exceptions A list of exception classes.
     * @return bool
     */
    protected function checkException(Exception $exception, array $exceptions): bool
    {
        foreach ($exceptions as $class) {
            if ($exception instanceof $class) {
                return true;
            }
        }

        return false;
    }
}