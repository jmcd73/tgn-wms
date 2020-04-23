<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Core\Configure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Sample middleware
 */
class HttpOptionsMiddleware implements MiddlewareInterface
{
    /**
     * Process method.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param  \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface      A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $response = $response->withHeader('X-Toggen', 'James McDonald');

        $origin = array_intersect(Configure::read('ALLOW_ORIGINS'), $request->getHeader('Origin'));
        if ($origin) {
            $response = $response->withHeader('Access-Control-Allow-Origin', $origin);
        }
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

        if ($request->getMethod() == 'OPTIONS') {
            $method = $request->getHeader('Access-Control-Request-Method');
            $headers = $request->getHeader('Access-Control-Request-Headers');
            $allowed = empty($method) ? 'GET, POST, PUT, DELETE' : $method;

            $response = $response
                    ->withHeader('Access-Control-Allow-Headers', $headers)
                    ->withHeader('Access-Control-Allow-Methods', $allowed)
                    ->withHeader('Access-Control-Allow-Credentials', 'true')
                    ->withHeader('Access-Control-Max-Age', '86400');
        }

        return $response;
    }
}