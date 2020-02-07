<?php

/**
 * fetch sends an OPTIONS pre-flight check
 * copy this file as OptionsFilter.php to app/Routing/Filter/OptionsFilter.php
 * load this DispatcherFilter by finding this block of code in
 * app/Config/bootstrap.php and appending the
 * 'OptionsFilter' entry
 * Configure::write('Dispatcher.filters', [
 *    'AssetDispatcher',
 *    'CacheDispatcher',
 *    'OptionsFilter' // custom by tgn
 * ]);
 *
 */

App::uses('DispatcherFilter', 'Routing');
App::uses('Configure', 'Core');

class OptionsFilter extends DispatcherFilter
{
    /**
     * @var int
     */
    public $priority = 9;

    /**
     * @param CakeEvent $event Event
     * @return mixed
     */
    public function beforeDispatch(CakeEvent $event)
    {
        $request = $event->data['request'];
        $response = $event->data['response'];

        // here is your allowed origins
        // I set them using Configure in bootstrap.php
        // Configure::write('ALLOWED_METHODS', ['PUT', 'POST', 'DELETE']);
        // Configure::write('ALLOWED_ORIGINS',['http://localhost:3000', 'http://localhost:8081']);

        $allowedOrigins = Configure::read('ALLOWED_ORIGINS');
        // here are the allowed methods
        $allowedMethods = Configure::read('ALLOWED_METHODS');

        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Max-Age
        // 2 hours
        $accessControlMaxAge = '7200';

        if ($request->is('OPTIONS')) {
            // where is the request coming from
            // e.g. from my react dev environment
            // it is http://localhost:3000
            $origin = $request->header('Origin');

            // what method are they requesting to use
            $method = $request->header('Access-Control-Request-Method');

            // what headers are they sending
            $headers = $request->header('Access-Control-Request-Headers');

            // if allow then set headers
            if (in_array($origin, $allowedOrigins)) {
                $response->header(
                    'Access-Control-Allow-Origin',
                    $origin
                );
            }

            if (in_array($method, $allowedMethods)) {
                $response->header(
                    'Access-Control-Allow-Methods',
                    $method
                );
            }

            $response->header(
                'Access-Control-Allow-Headers',
                $headers
            );
            $response->header('Access-Control-Allow-Credentials', 'true');
            $response->header('Access-Control-Max-Age', $accessControlMaxAge);
            $response->header('Content-Type', 'application/json');

            // this is just me goofing off
            // but this response viewed in the dev tools of the
            // browsers lets me know
            // I have triggered the DispatchFilter
            $response->body(
                json_encode(
                    [
                        'options' => 'pre-flight from dispatcher',
                    ]
                )
            );
            $event->stopPropagation();

            return $response;
        }
    }
}