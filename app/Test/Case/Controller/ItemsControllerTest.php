<?php
App::uses('ItemsController', 'Controller');

/**
 * ItemsController Test Case
 */
class ItemsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.item',
		'app.pack_size',
		'app.machines_standard_rate',
		'app.machine',
		'app.report',
		'app.report_date',
		'app.shift',
		'app.product_type',
		'app.location',
		'app.label',
		'app.shipment',
		'app.operator',
		'app.truck_registration',
		'app.inventory_status',
		'app.label_history',
		'app.user',
		'app.down_time',
		'app.downtime_type',
		'app.reason_code',
		'app.setting'
	);

/**
 * testPalletPrint method
 *
 * @return void
 */
	public function testPalletPrintPost() {
            
            $data = [
                'PalletLabel' => [
                
              
'formName' => 'left',
'item' => 221,
'production_line' => 2,
'product_type' => 'marg',
'part_pallet' => 0,
'batch_no' => 704495
            ]];
            
            $this->testAction('/items/pallet_print/marg', [
                'data' => $data, 'method' => 'POST'
            ]);
                  
            
		//$this->markTestIncomplete('testPalletPrint not implemented.');
            // redirect properly        
            $this->assertContains('/items/pallet_print/marg', $this->headers['Location']);
	}
        
        public function testPalletPrintGet(){
            
            $this->testAction('/items/pallet_print/oil',
                    [
                        'method' => 'GET'
                    ]
                    );
            
            $this->assertContains('60005 - VEG OIL 2L EXPORT', $this->vars['items']);
            debug($this->vars['items']);
            
            $this->testAction('/items/pallet_print/marg',
                    [
                        'method' => 'GET'
                    ]
                    );
            
            $this->assertContains('53121 - AUSSIE FARMERS BBLD 500G', $this->vars['items']);
               //debug($this->vars['items']);
               
        }

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->markTestIncomplete('testIndex not implemented.');
	}

/**
 * testProduct method
 *
 * @return void
 */
	public function testProduct() {
		$this->markTestIncomplete('testProduct not implemented.');
	}

/**
 * testPartList method
 *
 * @return void
 */
	public function testPartList() {
            
            $this->testAction('/items/part_list/5', [
                'method' => 'GET'
            ]);
            
            debug($this->vars['items']);
		//$this->markTestIncomplete('testPartList not implemented.');
	}

/**
 * testProductListByCode method
 *
 * @return void
 */
	public function testProductListByCode() {
		$this->markTestIncomplete('testProductListByCode not implemented.');
	}

/**
 * testProductList method
 *
 * @return void
 */
	public function testProductList() {
		$this->markTestIncomplete('testProductList not implemented.');
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->markTestIncomplete('testView not implemented.');
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$this->markTestIncomplete('testAdd not implemented.');
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$this->markTestIncomplete('testEdit not implemented.');
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
		$this->markTestIncomplete('testDelete not implemented.');
	}

}
