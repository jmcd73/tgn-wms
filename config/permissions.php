<?php

/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 * IMPORTANT:
 * This is an example configuration file. Copy this file into your config directory and edit to
 * setup your app permissions.
 *
 * This is a quick roles-permissions implementation
 * Rules are evaluated top-down, first matching rule will apply
 * Each line define
 *      [
 *          'role' => 'role' | ['roles'] | '*'
 *          'prefix' => 'Prefix' | , (default = null)
 *          'plugin' => 'Plugin' | , (default = null)
 *          'controller' => 'Controller' | ['Controllers'] | '*',
 *          'action' => 'action' | ['actions'] | '*',
 *          'allowed' => true | false | callback (default = true)
 *      ]
 * You could use '*' to match anything
 * 'allowed' will be considered true if not defined. It allows a callable to manage complex
 * permissions, like this
 * 'allowed' => function (array $user, $role, Request $request) {}
 *
 * Example, using allowed callable to define permissions only for the owner of the Posts to edit/delete
 *
 * (remember to add the 'uses' at the top of the permissions.php file for Hash, TableRegistry and Request
   [
        'role' => ['user'],
        'controller' => ['Posts'],
        'action' => ['edit', 'delete'],
        'allowed' => function(array $user, $role, Request $request) {
            $postId = Hash::get($request->params, 'pass.0');
            $post = $this->getTableLocator()->get('Posts')->get($postId);
            $userId = $user['id'] ?? null;
            if (!empty($post->user_id) && !empty($userId)) {
                return $post->user_id === $userId;
            }
            return false;
        }
    ],
 */

return [
      'canBestBeforeEdit' => [
        'roles' => [ 'qa', 'qty_editor' ],
        'users' => [ 'username' ]
    ],
    'CakeDC/Auth.permissions' => [
        [
            'controller' => 'Users',
            'action' => ['login'],
            'bypassAuth' => true,
        ],
        [
            'controller' => 'Shipments',
            'action' => ['addShipment', 'editShipment', 'destinationLookup', 'openShipments', 'view'],
            'bypassAuth' => true,
        ],
        [
            'controller' => 'Pallets',
            'action' => ['multiEdit',],
            'bypassAuth' => true,
        ],
        [
            'controller' => 'ProductTypes',
            'action' => 'view',
            'bypassAuth' => true,
        ],
        [
            'role' => 'admin',
            'prefix' => '*',
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
        ],
        [
            'role' => [ 'user', 'qty_editor', 'qa' ],
            'controller' => 'Users',
            'action' => [
                'accessDenied', 'logout',
            ],
        ],
        [
            'role' => [ 'user', 'qty_editor', 'qa' ],
            'controller' => [
                'Users',
                'Shifts',
                'Settings',
                'ProductTypes',
                'ProductionLines',
                'PrintTemplates',
                'Printers',
                'PackSizes',
                'Menus',
                'Locations',
                'InventoryStatuses',
            ],
            'action' => '*',
            'allowed' => false,
        ],
        [
            'role' => [ 'user', 'qty_editor', 'qa' ],
            'controller' => '*',
            'action' => [
                'display',
                'index',
                'view',
                'viewPageHelp',
            ],
        ],
        [
            'role' => [ 'user' ],
            'controller' => ['Pallets'],
            'action' => ['bulkStatusRemove'],
            'allowed' => function ($userEntity, $role, $request) {
                // allow users to view not update
                return !$request->is(['PUT', 'POST']);
            },
        ],

        [
            // user role cannot delete or edit add 
            'role' => [ 'user', 'qty_editor', 'qa' ],
            'controller' => ['Shipments'],
            // allow shipment delete
            'action' => ['delete'],
        ],
        [
            // user role cannot delete or edit add 
            'role' => [ 'user', 'qty_editor', 'qa' ],
            'controller' => ['PrintLog', 'Pallets', 'Items', 'Cartons', 'Shipments'],
            // allow all actions except these by prepending * to action
            '*action' => ['add', 'edit', 'newItemFromCopy', 'delete'],
        ],
    ],
];
