<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Printers seed.
 */
class PrintersSeed extends AbstractSeed
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
        $data = [
            [
                'id' => 6,
                'active' => true,
                'name' => 'PDF Printer',
                'options' => '',
                'queue_name' => 'PDF',
                'set_as_default_on_these_actions' => 'Pallets::lookup
Pallets::palletPrint
PrintLog::bigNumber
PrintLog::cartonPrint
PrintLog::crossdockLabels
PrintLog::customPrint
PrintLog::glabelSampleLabels
PrintLog::keepRefrigerated
PrintLog::palletLabelReprint
PrintLog::printCartonLabels
PrintLog::sampleLabels
PrintLog::shippingLabels
PrintLog::shippingLabelsGeneric
PrintLog::ssccLabel',
            ],
        ];

        $table = $this->table('printers');

        $table->truncate();

        $table->insert($data)->save();
    }
}
