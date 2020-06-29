<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PrintersFixture
 */
class PrintersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'options' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'queue_name' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'set_as_default_on_these_actions' => ['type' => 'string', 'length' => 2000, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'name_UNIQUE' => ['type' => 'unique', 'columns' => ['name'], 'length' => []],
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
                'id' => 6,
                'active' => true,
                'name' => 'PDF Printer',
                'options' => '',
                'queue_name' => 'PDF',
                'set_as_default_on_these_actions' => 'Pallets::lookup
PrintLog::bigNumber
PrintLog::crossdockLabels
PrintLog::glabelSampleLabels
PrintLog::keepRefrigerated
PrintLog::palletLabelReprint
PrintLog::printCartonLabels
PrintLog::shippingLabels
PrintLog::ssccLabel',
            ],
            [
                'id' => 24,
                'active' => true,
                'name' => 'TestPrinter',
                'options' => '',
                'queue_name' => 'TestPrinter',
                'set_as_default_on_these_actions' => 'Pallets::palletPrint',
            ],
        ];
        parent::init();
    }
}
