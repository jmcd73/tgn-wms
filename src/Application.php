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
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use App\Middleware\HttpOptionsMiddleware;
use App\Middleware\UnauthorizedHandler\CakeRedirectHandler;
use App\Policy\RbacPolicy;
use App\Policy\RequestPolicy;
use App\Policy\SuperuserPolicy;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Exception\ForbiddenException;
use Authorization\Exception\MissingIdentityException;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Middleware\RequestAuthorizationMiddleware;
use Authorization\Policy\MapResolver;
use Authorization\Policy\OrmResolver;
use Authorization\Policy\ResolverCollection;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Http\ServerRequest;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Utility\Security;
use CakeDC\Auth\Policy\CollectionPolicy;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 * AuthorizationServiceProviderInterface //readd for Authorization
 */
class Application extends BaseApplication implements
    AuthenticationServiceProviderInterface,
    AuthorizationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();
        $this->addPlugin('BootstrapUI');

        $this->addPlugin(\CakeDC\Auth\Plugin::class, ['bootstrap' => false]);
        $this->addPlugin('Authorization');
        $this->addPlugin('Authentication');

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
            # Configure::write('DebugKit.ignoreAuthorization', true);
            Configure::write('DebugKit.forceEnable', true);
        }
        // Load more plugins here
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param  \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $bodies = new BodyParserMiddleware();
        /*   $rbac = new RbacMiddleware(null, [
              'unauthorizedBehavior' => RbacMiddleware::UNAUTHORIZED_BEHAVIOR_REDIRECT,
              'unauthorizedRedirect' => [
                  'controller' => 'Users',
                  'action' => 'accessDenied',
              ],
          ]); */

        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            ->add(new HttpOptionsMiddleware())

            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            ->add(new RoutingMiddleware($this))
            ->add(new EncryptedCookieMiddleware(['CookieAuth'], Security::getSalt()))
            ->add(new AuthenticationMiddleware($this))
            ->add(
                new AuthorizationMiddleware(
                    $this,
                    [
                        'unauthorizedHandler' => [
                            'className' => CakeRedirectHandler::class,
                            'url' => [
                                'controller' => 'Users',
                                'action' => 'login',
                            ],
                            'queryParam' => 'redirect',
                            'exceptions' => [
                                MissingIdentityException::class,
                                ForbiddenException::class,
                            ],
                            'customUrlMap' => [
                                ForbiddenException::class => [
                                    'controller' => 'Users',
                                    'action' => 'accessDenied',
                                ],
                            ],
                        ],
                    ]
                )
            )
            ->add(new RequestAuthorizationMiddleware())
            // ->add($rbac)
            ->add($bodies);
        // Ensure routing middleware is added to the queue before CSRF protection middleware.

        //  ->add(new AuthorizationMiddleware($this))

        return $middlewareQueue;
    }

    /**
     * Bootrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }

        $this->addPlugin('Migrations');

        // Load more plugins here
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $authenticationService = new AuthenticationService();

        $loginUrl = '/' . Configure::read('WEB_DIR') . '/users/login';

        $authenticationService->setConfig([
            'unauthenticatedRedirect' => $loginUrl,
            'queryParam' => 'redirect',
        ]);

        $fields = [
            'username' => 'username',
            'password' => 'password',
        ];

        $resolver = [
            'className' => 'Authentication.Orm',
            'finder' => 'active',
        ];

        // Load identifiers, ensure we check email and password fields
        $authenticationService->loadIdentifier('Authentication.Token', [
            'tokenField' => 'token_auth_key',
            'resolver' => $resolver,
        ]);
        $authenticationService->loadIdentifier(
            'Authentication.Password',
            [
                'fields' => $fields,
                'resolver' => $resolver,
            ]
        );

        /*  $authenticationService->loadAuthenticator(
             'Authentication.Cookie',
             [
                 'rememberMeField' => 'remember_me',
                 'fields' => $fields,
             ]
         );
 */

        $authenticationService->loadAuthenticator('Authentication.Token', [
            'queryParam' => 'token',
            'header' => 'Authorization',
            'tokenPrefix' => 'Token',
            'tokenField' => 'token_auth_key',
        ]);
        // Load the authenticators, you want session first
        $authenticationService->loadAuthenticator(
            'Authentication.Session',
            [
                'skipTwoFactorVerify' => true,
            ]
        );

        // Configure form data check to pick email and password
        $authenticationService->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => $loginUrl,
        ]);

        return $authenticationService;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $map = new MapResolver();
        $map->map(
            ServerRequest::class,
            new CollectionPolicy([
                RequestPolicy::class, // skip DebugKit
                SuperuserPolicy::class, //First check super user policy
                RbacPolicy::class, // Only check with rbac if user is not super user
            ])
        );

        //            RequestPolicy::class,

        $orm = new OrmResolver();

        $resolver = new ResolverCollection([
            $map,
            $orm,
        ]);

        return new AuthorizationService($resolver);
    }
}
