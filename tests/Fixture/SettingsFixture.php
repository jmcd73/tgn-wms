<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SettingsFixture
 */
class SettingsFixture extends TestFixture
{

    public $import = ['table' => 'settings'];

    public $records = [
        [
            'id' => 3,
            'setting_in_comment' =>    false,
            'name' =>    'SSCC_REF',
            'setting' =>    '427',
            'comment' =>    'SSCC Reference number ',
        ],
        [
            'id' => 4,
            'setting_in_comment' =>    false,
            'name' =>    'SSCC_EXTENSION_DIGIT',
            'setting' =>    '1',
            'comment' =>    'SSCC extension digit',

        ],
        [
            'id' => 5,
            'setting_in_comment' =>    false,
            'name' =>    'SSCC_COMPANY_PREFIX',
            'setting' =>    '93529380',
            'comment' =>    'Added a bogus prefix',

        ],
        [
            'id' => 10,
            'setting_in_comment' =>    false,
            'name' =>    'COMPANY_NAME',
            'setting' =>    'Australasian Food Exports Pty Ltd',
            'comment' =>    'This is used for the title attribute of pages and for anywhere the company name is needed (label headings)',
        ],
        [
            'id' => 13,
            'setting_in_comment' =>    false,
            'name' =>    'COOL_DOWN_HRS',
            'setting' =>    '48',
            'comment' =>    'Cooldown time in hours',

        ],
        [
            'id' => 24,
            'setting_in_comment' =>    false,
            'name' =>    'MIN_DAYS_LIFE',
            'setting' =>    '210',
            'comment' =>    'Specifies how many days life need to still be on the product before it is considered unshippable to customers',


        ],

        [
            'id' => 29,
            'setting_in_comment' =>    false,
            'name' =>    'MAX_SHIPPING_LABELS',
            'setting' =>    '70',
            'comment' =>    'Max shipping labels',

        ],
        [
            'id' => 30,
            'setting_in_comment' =>    false,
            'name' =>    'TEMPLATE_ROOT',
            'setting' =>    'files/templates-glabels-3',
            'comment' =>    'Options for TEMPLATE_ROOT files/templates-glabels-3 files/templates-glabels-4',


        ], [
            'id' => 61,
            'setting_in_comment' =>    false,
            'name' =>    'DOCUMENTATION_ROOT',
            'setting' =>    'docs/help',
            'comment' =>    'Relative to WWW_ROOT',

        ],

        [
            'id' => 62,
            'setting_in_comment' =>    false,
            'name' =>    'SSCC_DEFAULT_LABEL_COPIES',
            'setting' =>    '2',
            'comment' =>    'Global default for SSCC Pallet Label Copies',

        ],
        [
            'id' => 66,
            'setting_in_comment' =>    true,
            'name' =>    'EMAIL_PALLET_LABEL_TO',
            'setting' =>    'Send the pallet label to an email address',
            'comment' =>    '# Format: FirstName LastName <email@example.com>\n# to disable send put a # at the start of the line \nJames McDonald <james@toggen.com.au> # Lisa McDonald <lisa@toggen.com.au> ',

        ]

    ];
}
