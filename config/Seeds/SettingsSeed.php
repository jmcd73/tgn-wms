<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Settings seed.
 */
class SettingsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data =  [
            [
                'id' => 3,
                'name' => 'SSCC_REF',
                'setting' => '21',
                'comment' => 'The next SSCC Reference number',
            ],
            [
                'id' => 4,
                'name' => 'SSCC_EXTENSION_DIGIT',
                'setting' => '1',
                'comment' => 'SSCC extension digit',
            ],
            [
                'id' => 5,
                'name' => 'SSCC_COMPANY_PREFIX',
                'setting' => '99999999',
                'comment' => 'Added a bogus prefix',
            ],
            [
                'id' => 10,
                'name' => 'COMPANY_NAME',
                'setting' => 'The Toggen Partnership',
                'comment' => 'This is used for the title attribute of pages and for anywhere the company name is needed (label headings)',
            ],
            [
                'id' => 13,
                'name' => 'COOL_DOWN_HRS',
                'setting' => '48',
                'comment' => 'Cooldown time in hours',
            ],
            [
                'id' => 24,
                'name' => 'MIN_DAYS_LIFE',
                'setting' => '210',
                'comment' => 'Specifies how many days life need to still be on the product before it is considered unshippable to customers',
            ],
            [
                'id' => 29,
                'name' => 'MAX_SHIPPING_LABELS',
                'setting' => '70',
                'comment' => 'Max shipping labels',
            ],
            [
                'id' => 30,
                'name' => 'TEMPLATE_ROOT',
                'setting' => 'files/templates-glabels-3',
                'comment' => 'Options for TEMPLATE_ROOT
files/templates-glabels-3	
files/templates-glabels-4',
            ],
            [
                'id' => 61,
                'name' => 'DOCUMENTATION_ROOT',
                'setting' => 'docs/help',
                'comment' => 'Relative to WWW_ROOT',
            ],
            [
                'id' => 62,
                'name' => 'SSCC_DEFAULT_LABEL_COPIES',
                'setting' => '2',
                'comment' => 'Global default for SSCC Pallet Label Copies',
            ],
            [
                'id' => 66,
                'name' => 'EMAIL_PALLET_LABEL_TO',
                'setting' => '# Format: FirstName LastName <email@example.com> 
# to disable send put a # at the start of the line
James McDonald <james@toggen.com.au>
#Lisa McDonald <lisa@toggen.com.au>
',
                'comment' =>'Send the pallet label to an email address'
            ],
            [
                'id' => 67,
                'name' => 'LABEL_OUTPUT_PATH',
                'setting' => 'files/output',
                'comment' => 'relative path from WWW_ROOT for saving output files from GLabels Print',
            ],
            [
                'id' => 68,
                'name' => 'LABEL_DOWNLOAD_LIST',
                'setting' => '8',
                'comment' => 'Whether to show the recently printed label download list
0 to disable
1 - 20 yes and number to show
',
            ],
            [
                'id' => 69,
                'name' => 'SHOW_ADD_MIXED',
                'setting' => '1',
                'comment' => 'Show the "Add Mixed" Shipment Link
0 = No
1 = Yes',
            ],
        ];

        $table = $this->table('settings');
        
        $table->truncate();
        
        $table->insert($data)->save();
    }
}
