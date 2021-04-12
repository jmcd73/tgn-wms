<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Faker\Factory;
use App\Lib\Utility\Barcode;
use Bezhanov\Faker\ProviderCollectionHelper;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Items seed.
 */
class ItemsSeed extends AbstractSeed
{

    use LocatorAwareTrait;
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
                'active' => true,
                'code' => 'OO116',
                
                'quantity' => 168,
                'trade_unit' => '19310175701106',
                'pack_size_id' => 2,
                'product_type_id' => 3,
                'consumer_unit' => '9310175701109',
                'brand' => 'Toggen Leisure',
                
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 73,
                'carton_template_id' => 5,
                'pallet_label_copies' => 1,
                'created' => '2020-06-21 18:14:48',
                'modified' => '2020-06-25 15:17:41',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 750ml',
                'batch_format' => 'YDDD',
            ],
            [
            
                'active' => true,
                'code' => 'OO123',
                
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 3,
                'product_type_id' => 3,
                'consumer_unit' => '',
                'brand' => 'Toggen Leisure',
                
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 73,
                'carton_template_id' => 5,
                'pallet_label_copies' => 1,
                'created' => '2020-06-21 18:20:26',
                'modified' => '2020-06-28 13:53:03',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 375ml',
                'batch_format' => 'YDDD',
            ],
            [
        
                'active' => true,
                'code' => 'OO115',
                
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 2,
                'product_type_id' => 3,
                'consumer_unit' => '',
                'brand' => 'Toggen Leisure',
                
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 2,
                'carton_template_id' => 5,
                'pallet_label_copies' => 1,
                'created' => '2020-06-21 22:56:38',
                'modified' => '2020-06-24 19:23:07',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 750ml',
                'batch_format' => 'YDDD',
            ],
            [
            
                'active' => false,
                'code' => 'OO345',
                
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 3,
                'product_type_id' => 3,
                'consumer_unit' => '',
                'brand' => 'Toggen Leisure',
                
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 73,
                'carton_template_id' => 5,
                'pallet_label_copies' => 0,
                'created' => '2020-06-25 12:26:14',
                'modified' => '2020-06-25 15:18:57',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 375ml',
                'batch_format' => '',
            ],
            [
                'active' => true,
                'code' => 'OO145',
                
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 3,
                'product_type_id' => 3,
                'consumer_unit' => '0000000000000',
                'brand' => 'Toggen Leisure',
                
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 61,
                'carton_template_id' => 5,
                'pallet_label_copies' => 0,
                'created' => '2020-06-29 11:47:10',
                'modified' => '2020-06-29 18:17:46',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 375ml',
                'batch_format' => '',
            ],
        ];

        $faker = Factory::create();
        ProviderCollectionHelper::addAllProvidersTo($faker);

        $packSizes = $this->getTableLocator()->get('PackSizes')->find()->select(['id'])->extract('id')->toArray();

       

        foreach($data as $k => $d){
            $bc = $faker->ean13;
            $data[$k]['id'] = $faker->unique()->numberBetween(6,20);
            $data[$k]['consumer_unit'] = $bc;
            $data[$k]['trade_unit'] = $this->gtin14($bc);
            $data[$k]['description'] = $faker->productName;
            $data[$k]['code'] =  strtoupper(join('', [ $faker->randomLetter, $faker->randomLetter ])  . $faker->randomNumber(3));
            $data[$k]['variant'] = $faker->productName;
            $data[$k]['quantity'] = $faker->unique()->numberBetween(38, 168);
            $data[$k]['pack_size_id'] = $faker->randomElement($packSizes);
        }

        $table = $this->table('items');
        $table->truncate();
        $table->insert($data)->save();
    }

    public function gtin14($ean13)
    {
        $left = substr($ean13, 0, -1);
       
        return (new Barcode())->generateSSCCWithCheckDigit('1' . $left);
    }
}
