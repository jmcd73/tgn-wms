<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddLabelDownload extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {
        /* $this->table('cartons')
            ->removeIndexByName('date_label_id')
            ->update();
 */
        $this->table('cartons')
            ->addIndex(
                [
                    'pallet_id',
                    'best_before',
                ],
                [
                    'name' => 'pallet_id_best_before_uq',
                    'unique' => true,
                ]
            )
            ->update();

        $this->table('pallets')
            ->addColumn('pallet_label_filename', 'string', [
                'after' => 'product_type_serial',
                'default' => null,
                'length' => 60,
                'null' => true,
            ])
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {

        $this->table('cartons')
            ->removeIndexByName('pallet_id_best_before_uq')
            ->update();

        $this->table('cartons')
            ->addIndex(
                [
                    'pallet_id',
                    'best_before',
                ],
                [
                    'name' => 'date_label_id',
                    'unique' => true,
                ]
            )
            ->update();

        $this->table('pallets')
            ->removeColumn('pallet_label_filename')
            ->update();
    }
}
