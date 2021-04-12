<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SettingsFixture
 */
class SettingsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'setting' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'name' => ['type' => 'unique', 'columns' => ['name'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 3,
                'name' => 'SSCC_REF',
                'comment' => 'SSCC Reference number',
                'setting' => '302',
            ],
            [
                'id' => 4,
                'name' => 'SSCC_EXTENSION_DIGIT',
                'comment' => 'SSCC extension digit',
                'setting' => '1',
            ],
            [
                'id' => 5,
                'name' => 'SSCC_COMPANY_PREFIX',
                'comment' => 'Added a bogus prefix',
                'setting' => '99999999',
            ],
            [
                'id' => 10,
                'name' => 'COMPANY_NAME',
                'comment' => 'This is used for the title attribute of pages and for anywhere the company name is needed (label headings)',
                'setting' => 'Australasian Food Exports Pty Ltd',
            ],
            [
                'id' => 13,
                'name' => 'COOL_DOWN_HRS',
                'comment' => 'Cooldown time in hours',
                'setting' => '48',
            ],
            [
                'id' => 24,
                'name' => 'MIN_DAYS_LIFE',
                'comment' => 'Specifies how many days life need to still be on the product before it is considered unshippable to customers',
                'setting' => '210',
            ],
            [
                'id' => 29,
                'name' => 'MAX_SHIPPING_LABELS',
                'comment' => 'Max shipping labels',
                'setting' => '70',
            ],
            [
                'id' => 30,
                'name' => 'TEMPLATE_ROOT',
                'comment' => 'Options for TEMPLATE_ROOT
files/templates-glabels-3	
files/templates-glabels-4',
                'setting' => 'files/templates-glabels-3',
            ],
            [
                'id' => 61,
                'name' => 'DOCUMENTATION_ROOT',
                'comment' => 'Relative to WWW_ROOT',
                'setting' => 'docs/help',
            ],
            [
                'id' => 62,
                'name' => 'SSCC_DEFAULT_LABEL_COPIES',
                'comment' => 'Global default for SSCC Pallet Label Copies',
                'setting' => '2',
            ],
            [
                'id' => 66,
                'name' => 'EMAIL_PALLET_LABEL_TO',
                'comment' => 'Send the pallet label to an email address
# Format: FirstName LastName <email@example.com> 
# to disable send put a # at the start of the line

# Greg Fry <greg@multibevco.com.au>
#Lisa McDonald <lisa@toggen.com.au>',
                'setting' => 'James McDonald <james@toggen.com.au>
# Format: FirstName LastName <email@example.com> 
# to disable send put a # at the start of the line

# Greg Fry <greg@multibevco.com.au>
Lisa McDonald <lisa@toggen.com.au>',
            ],
            [
                'id' => 67,
                'name' => 'LABEL_OUTPUT_PATH',
                'comment' => 'Relative path from WWW_ROOT for saving labels that can be downloaded
',
                'setting' => 'files/output',
            ],
            [
                'id' => 68,
                'name' => 'LABEL_DOWNLOAD_LIST',
                'comment' => 'Whether to show the recently printed label download list
0 to disable
1 - 20 yes and number to show',
                'setting' => '10',
            ],
            [
                'id' => 69,
                'name' => 'SHOW_ADD_MIXED',
                'comment' => 'Show the "Add Mixed" Shipment Link
0 = No
1 = Yes',
                'setting' => '1',
            ],
        ];
        parent::init();
    }
}
