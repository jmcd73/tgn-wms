<?php

$appName = 'Toggen WMS';
$companyName = 'Toggen Systems';

$glabelsBatchBinary = file_exists('/.dockerenv') ? [
    '/usr/bin/xvfb-run', '--',
    '/usr/local/glabels-qt/usr/bin/glabels-batch-qt',
] : [
    '/usr/local/bin/glabels-batch-qt', '--',
];

return [
    // in Lib/Utility/Barcode
    'BATCH_FORMATS' => [
        'YDDDXX' => [
            'description' => "YDDDXX e.g. 2020 Jan 5 batch 3 = 000503 (default)",
            'start' => 1,
            'end' => 99
        ],
        'YDDD' => [
            'description' => "YDDD e.g. 2020 Jan 5 = 0005. Squeaky Gate",
            ]
        ],
    'ALLOWED_METHODS' => ['PUT', 'POST'],
    'ALLOWED_ORIGINS' => ['http://localhost:3000', 'http://localhost:8082'],
    'MAX_COPIES' => 100,
    'GLABELS_LIBRARY_PATH' => '/usr/local/glabels-qt/usr/lib',
    'GLABELS_BATCH_BINARY' => $glabelsBatchBinary,
    'timezones' => DateTimeZone::AUSTRALIA, // extras with a pipe | DateTimeZone::EUROPE,
    'dateFormat' => 'd/m/Y',
    'BestBeforeDateEditors' => [],
    'PrintLabels' => [
        // mappings for controller print actions to their classes
        // used by Lib/PrintLabels/LabelFactory.php
        'glabelSampleLabels' => '\App\Lib\PrintLabels\Glabel\GlabelSample',
        'keepRefrigerated' => '\App\Lib\PrintLabels\Glabel\CustomLabel',
        'customPrint' => '\App\Lib\PrintLabels\Glabel\CustomLabel',
        'shippingLabels' => '\App\Lib\PrintLabels\Glabel\ShippingLabel',
        'crossdockLabels' => '\App\Lib\PrintLabels\Glabel\CrossdockLabel',
        'shippingLabelsGeneric' => '\App\Lib\PrintLabels\Glabel\ShippingLabelGeneric',
        'bigNumber' => '\App\Lib\PrintLabels\Zebra\TextLabel',
        'printCartonLabels' => '\App\Lib\PrintLabels\CabLabel\CartonLabel',
        'sampleLabels' => '\App\Lib\PrintLabels\Glabel\SampleLabel',
        'palletPrint' =>  '\App\Lib\PrintLabels\Glabel\SsccLabel',
	//'\App\Lib\PrintLabels\CabLabel\PalletPrint',
        'palletReprint' =>  '\App\Lib\PrintLabels\Glabel\SsccLabel',
	//'\App\Lib\PrintLabels\CabLabel\PalletPrint',
        'ssccLabel' => '\App\Lib\PrintLabels\Glabel\SsccLabel',
    ],
    // specify the Controller and actions that need a default printer set
    'Ctrl' => [
        'printControllersActions' => [
            'Pallets' => [
                'palletPrint',
                'palletReprint',
                'lookup',
            ],
            'PrintLog' => [
                'printCartonLabels',
                'cartonPrint',
                'crossdockLabels',
                'shippingLabels',
                'shippingLabelsGeneric',
                'keepRefrigerated',
                'glabelSampleLabels',
                'bigNumber',
                'customPrint',
                'customPrint',
                'sampleLabels',
                'ssccLabel', ],
        ], ],
    // setting in settings table that holds the GS1 Company Prefix for use with
    // SSCC labels
    'SSCC_COMPANY_PREFIX' => 'sscc_company_prefix',
    'SSCC_EXTENSION_DIGIT' => 'sscc_extension_digit',
    'SSCC_REF' => 'sscc_ref',
    'companyName' => $companyName,
    'applicationName' => $appName,
    'labelMaxCopies' => 400,
    'App' => [
        'title' => 'Toggen',
    ],
    'PalletsLookup' => [
        'limit' => 20,
        'maxLimit' => 30,
    ],
    'MaxShippingLabels' => 70,
    'LabelsRolesActions' => [
        [
            'roles' => ['qa'], // single value must be array
            'actions' => ['editPallet', 'bulkStatusRemove', 'editPalletCartons'],
        ],
        [
            'roles' => ['qty_editor'],
            'actions' => ['editPallet'],
        ],
    ],
    // Pallets/onhand action page size
    // display this many in view
    'onhandPageSize' => 1000,
    'StockViewPerms' => [
        [
            'value' => 1,
            'slug' => 'view_in_stock',
            'display' => 'Visible in view stock',
        ],
        [
            'value' => 2,
            'slug' => 'view_in_shipments',
            'display' => 'Visible when creating shipment',
        ],
        [
            'value' => 4,
            'slug' => 'view_in_lookup_table',
            'display' => 'Visble in Pallet Track (always select this)', ],
        [
            'value' => 8,
            'slug' => 'view_in_remove_status',
            'display' => 'List this status in Edit QA Status screen',
        ],
    ],
    'Users' => [
        'admin_role' => 'admin',
        'roles' => [
            [
                'slug' => 'admin',
                'name' => 'Administrators',
                'description' => 'Access to view, update and delete everything',
            ],

            [
                'slug' => 'qa',
                'name' => 'Quality Assurance',
                'description' => 'QA Functions',
            ],
            [
                'slug' => 'user',
                'name' => 'User',
                'description' => 'User can view and update most areas, some restrictions',
            ],
            [
                'slug' => 'qty_editor',
                'name' => 'Edit Pallet Quantities',
                'description' => 'Limited to editing pallet qauntities',
            ],
        ],
    ],
    /*
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
        'HOME' => 'default',
        'TEST' => 'test',
        'NEWTEST' => 'palletsTest',
        'TGN' => 'tgn',
    ],
    'navbar' => [
        'brand' => [
            'title' => 'Toggen home',
            'img' => 'TOGGEN-GOAT.svg',
            'alt' => 'Toggen home',
        ],
    ],
    'login' => [
        'image' => 'favicon.png',
    ],
    'footer' => [
        'img' => 'footer.jpg',
    ],
    'contact' => [
        'company' => 'Toggen',
        'name' => 'James McDonald',
        'phone' => '0428 964 633',
        'phone_dial' => '+61428964633',
        'company_url' => 'https://toggen.com.au',
    ],
    'PdfPickList' => [
        'KeyWords' => ['Pick List'],
        'img' => 'TOGGEN-GOAT.svg',
        'FileNameSuffix' => '_pick_list.pdf',
    ],
];
