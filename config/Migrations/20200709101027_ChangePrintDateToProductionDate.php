<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\Database\Expression\QueryExpression;

class ChangePrintDateToProductionDate extends AbstractMigration
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

        $this->table('pallets')
            ->addColumn('production_date', 'datetime', [
                'after' => 'printer_id',
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'production_date',
                ],
                [
                    'name' => 'production_date_desc',
                ]
            )
            ->update();

            $builder = $this->getQueryBuilder();
        
            $exp = $builder->newExpr('print_date');
    
            $statement = $builder->update('pallets')->set('production_date', $exp);
    
            $statement->execute();

            $this->table('pallets')
                ->removeColumn('print_date')    
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

        $this->table('pallets')
        ->addColumn('print_date', 'datetime', [
            'after' => 'printer_id',
            'default' => null,
            'length' => null,
            'null' => false,
        ])
        ->addIndex(
            [
                'print_date',
            ],
            [
                'name' => 'print_date_desc',
            ]
        )
        ->update();


        $builder = $this->getQueryBuilder();
    
        $exp = $builder->newExpr('production_date');

        $statement = $builder->update('pallets')->set('print_date', $exp);

        $statement->execute();

      
        $this->table('pallets')
            ->removeColumn('production_date')
            ->update();

    }
}
