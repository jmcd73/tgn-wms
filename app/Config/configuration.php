<?php

$config = [
    'ALLOWED_METHODS' => ['PUT', 'POST'],
    'ALLOWED_ORIGINS' => ['http://localhost:3000', 'http://localhost:8082'],
    'labelMaxCopies' => 400,
    'MaxShippingLabels' => 70,
    'LabelsRolesActions' => [
        [
            'roles' => ['qa'], // single value must be array
             'actions' => ['editPallet', 'bulkStatusRemove']
        ],
        [
            'roles' => ['qty_editor'],
            'actions' => ['editPallet']
        ]
    ],
    'BestBeforeDateEditors' => [
        //list of user names
         'petersj',
        'rogerh'
    ],
    'StorageTemperatures' => [
        'Ambient',
        'Chilled'
    ],
    'StockViewPerms' => [
        [
            'value' => 1,
            'slug' => 'view_in_stock',
            'display' => 'Visible in view stock'
        ],
        [
            'value' => 2,
            'slug' => 'view_in_shipments',
            'display' => 'Visible when creating shipment'
        ],
        [
            'value' => 4,
            'slug' => 'view_in_lookup_table',
            'display' => 'Visble in Pallet Track (always select this)'],
        [
            'value' => 8,
            'slug' => 'view_in_remove_status',
            'display' => 'List this status in Edit QA Status screen'
        ]
    ],
    'Users' =>
    [
        'roles' => [
            'admin' => 'Administrators',
            'qa' => "Quality Assurance",
            'user' => "User",
            'qty_editor' => "Edit Pallet Quantities"
        ]
    ],
    /**
     * The datasources key allows you to set an environment variable
     * in Apache using SetEnv ENVIRONMENT HOME
     * and it will then map to your database.php DB configuration
     * so setting ENVIRONMENT to HOME will load the $home property
     * in the DATABASE_CONFIG class specified in
     * app/Config/database.php
     *
     * SetEnv ENVIRONMENT LIVE|HOME|TEST in .htaccess
     * */
    'datasources' => [
        'HOME' => 'home', // my laptop
         'TEST' => 'default', // test
         'NEWTEST' => 'palletsTest'
    ],
    'navbar' => [
        'brand' => [
            'title' => "Toggen home",
            'img' => 'home.png',
            'alt' => 'Toggen home'
        ]
    ],
    'footer' => [
        'img' => 'footer.jpg'
    ],
    'contact' => [
        'company' => "Toggen",
        'name' => 'James McDonald',
        'phone' => '0428 964 633',
        'phone_dial' => '+61428964633',
        'company_url' => 'https://toggen.com.au'

    ]
];
