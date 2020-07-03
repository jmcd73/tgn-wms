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
        'setting_in_comment' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'setting' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
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
                'setting_in_comment' => false,
                'name' => 'SSCC_REF',
                'setting' => '21',
                'comment' => 'The next SSCC Reference number',
            ],
            [
                'id' => 4,
                'setting_in_comment' => false,
                'name' => 'SSCC_EXTENSION_DIGIT',
                'setting' => '1',
                'comment' => 'SSCC extension digit',
            ],
            [
                'id' => 5,
                'setting_in_comment' => false,
                'name' => 'SSCC_COMPANY_PREFIX',
                'setting' => '99999999',
                'comment' => 'Added a bogus prefix',
            ],
            [
                'id' => 10,
                'setting_in_comment' => false,
                'name' => 'COMPANY_NAME',
                'setting' => 'The Toggen Partnership',
                'comment' => 'This is used for the title attribute of pages and for anywhere the company name is needed (label headings)',
            ],
            [
                'id' => 13,
                'setting_in_comment' => false,
                'name' => 'COOL_DOWN_HRS',
                'setting' => '48',
                'comment' => 'Cooldown time in hours',
            ],
            [
                'id' => 24,
                'setting_in_comment' => false,
                'name' => 'MIN_DAYS_LIFE',
                'setting' => '210',
                'comment' => 'Specifies how many days life need to still be on the product before it is considered unshippable to customers',
            ],
            [
                'id' => 29,
                'setting_in_comment' => false,
                'name' => 'MAX_SHIPPING_LABELS',
                'setting' => '70',
                'comment' => 'Max shipping labels',
            ],
            [
                'id' => 30,
                'setting_in_comment' => false,
                'name' => 'TEMPLATE_ROOT',
                'setting' => 'files/templates-glabels-3',
                'comment' => 'Options for TEMPLATE_ROOT
files/templates-glabels-3	
files/templates-glabels-4',
            ],
            [
                'id' => 61,
                'setting_in_comment' => false,
                'name' => 'DOCUMENTATION_ROOT',
                'setting' => 'docs/help',
                'comment' => 'Relative to WWW_ROOT',
            ],
            [
                'id' => 62,
                'setting_in_comment' => false,
                'name' => 'SSCC_DEFAULT_LABEL_COPIES',
                'setting' => '2',
                'comment' => 'Global default for SSCC Pallet Label Copies',
            ],
            [
                'id' => 66,
                'setting_in_comment' => true,
                'name' => 'EMAIL_PALLET_LABEL_TO',
                'setting' => 'Send the pallet label to an email address',
                'comment' => '# Format: FirstName LastName <email@example.com> 
# to disable send put a # at the start of the line
James McDonald <james@toggen.com.au>
#Lisa McDonald <lisa@toggen.com.au>
',
            ],
            [
                'id' => 67,
                'setting_in_comment' => false,
                'name' => 'LABEL_OUTPUT_PATH',
                'setting' => 'files/output',
                'comment' => 'relative path from WWW_ROOT for saving output files from GLabels Print',
            ],
            [
                'id' => 68,
                'setting_in_comment' => false,
                'name' => 'LABEL_DOWNLOAD_LIST',
                'setting' => '8',
                'comment' => 'Whether to show the recently printed label download list
0 to disable
1 - 20 yes and number to show
',
            ],
            [
                'id' => 69,
                'setting_in_comment' => false,
                'name' => 'SHOW_ADD_MIXED',
                'setting' => '1',
                'comment' => 'Show the "Add Mixed" Shipment Link
0 = No
1 = Yes',
            ],
        ];
        parent::init();
    }
}
