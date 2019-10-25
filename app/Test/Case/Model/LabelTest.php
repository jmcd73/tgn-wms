<?php
App::uses('Label', 'Model');

/**
 * Label Test Case
 */
class LabelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.label',
		'app.product_type',
		'app.location',
		'app.inventory_status',
		'app.production_line',
		'app.printer',
		'app.item',
		'app.pack_size',
		'app.print_template',
		'app.shift',
		'app.shipment',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Label = ClassRegistry::init('Label');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Label);

		parent::tearDown();
	}

/**
 * testGetWarehouseAislesColumnsLevels method
 *
 * @return void
 */
	public function testGetWarehouseAislesColumnsLevels() {
		$this->markTestIncomplete('testGetWarehouseAislesColumnsLevels not implemented.');
	}

/**
 * testArrayKeysExists method
 *
 * @return void
 */
	public function testArrayKeysExists() {
		$this->markTestIncomplete('testArrayKeysExists not implemented.');
	}

/**
 * testChangeCooldownAndStatusIfAddingCartons method
 *
 * @return void
 */
	public function testChangeCooldownAndStatusIfAddingCartons() {
		$this->markTestIncomplete('testChangeCooldownAndStatusIfAddingCartons not implemented.');
	}

/**
 * testIsMarg method
 *
 * @return void
 */
	public function testIsMarg() {
		$this->markTestIncomplete('testIsMarg not implemented.');
	}

/**
 * testIsProduct method
 *
 * @return void
 */
	public function testIsProduct() {
		$this->markTestIncomplete('testIsProduct not implemented.');
	}

/**
 * testEnumShifts method
 *
 * @return void
 */
	public function testEnumShifts() {
		$this->markTestIncomplete('testEnumShifts not implemented.');
	}

/**
 * testGetShiftReport method
 *
 * @return void
 */
	public function testGetShiftReport() {
		$this->markTestIncomplete('testGetShiftReport not implemented.');
	}

/**
 * testIsFloor method
 *
 * @return void
 */
	public function testIsFloor() {
		$this->markTestIncomplete('testIsFloor not implemented.');
	}

/**
 * testIsMargLocation method
 *
 * @return void
 */
	public function testIsMargLocation() {
		$this->markTestIncomplete('testIsMargLocation not implemented.');
	}

/**
 * testFindLocationById method
 *
 * @return void
 */
	public function testFindLocationById() {
		$this->markTestIncomplete('testFindLocationById not implemented.');
	}

/**
 * testResolvePutAwayLocation method
 *
 * @return void
 */
	public function testResolvePutAwayLocation() {
		$this->markTestIncomplete('testResolvePutAwayLocation not implemented.');
	}

/**
 * testGetProductType method
 *
 * @return void
 */
	public function testGetProductType() {
		$this->markTestIncomplete('testGetProductType not implemented.');
	}

/**
 * testGetColumnsAndLevels method
 *
 * @return void
 */
	public function testGetColumnsAndLevels() {
		$this->markTestIncomplete('testGetColumnsAndLevels not implemented.');
	}

/**
 * testGetLocationIdFromLocationName method
 *
 * @return void
 */
	public function testGetLocationIdFromLocationName() {
		$this->markTestIncomplete('testGetLocationIdFromLocationName not implemented.');
	}

/**
 * testGetDontShipCount method
 *
 * @return void
 */
	public function testGetDontShipCount() {
		$this->markTestIncomplete('testGetDontShipCount not implemented.');
	}

/**
 * testGetViewOptions method
 *
 * @return void
 */
	public function testGetViewOptions() {
		$this->markTestIncomplete('testGetViewOptions not implemented.');
	}

/**
 * testGetFilterValues method
 *
 * @return void
 */
	public function testGetFilterValues() {
		$this->markTestIncomplete('testGetFilterValues not implemented.');
	}

/**
 * testFormatLookupRequestData method
 *
 * @return void
 */
	public function testFormatLookupRequestData() {
		$this->markTestIncomplete('testFormatLookupRequestData not implemented.');
	}

/**
 * testFormatLookupActionConditions method
 *
 * @return void
 */
	public function testFormatLookupActionConditions() {
		$this->markTestIncomplete('testFormatLookupActionConditions not implemented.');
	}

/**
 * testCheckEnableShipLowDate method
 *
 * @return void
 */
	public function testCheckEnableShipLowDate() {
		$this->markTestIncomplete('testCheckEnableShipLowDate not implemented.');
	}

/**
 * testCheckChangeOK method
 *
 * @return void
 */
	public function testCheckChangeOK() {
		$this->markTestIncomplete('testCheckChangeOK not implemented.');
	}

/**
 * testSetDaysLife method
 *
 * @return void
 */
	public function testSetDaysLife() {
		$this->markTestIncomplete('testSetDaysLife not implemented.');
	}

/**
 * testCreateSuccessMessage method
 *
 * @return void
 */
	public function testCreateSuccessMessage() {
		$this->markTestIncomplete('testCreateSuccessMessage not implemented.');
	}

/**
 * testGenerateSSCC method
 *
 * @return void
 */
	public function testGenerateSSCC() {
		$this->markTestIncomplete('testGenerateSSCC not implemented.');
	}

/**
 * testGenerateCheckDigit method
 *
 * @return void
 */
	public function testGenerateCheckDigit() {
		$this->markTestIncomplete('testGenerateCheckDigit not implemented.');
	}

/**
 * testHasQtyChanged method
 *
 * @return void
 */
	public function testHasQtyChanged() {
		$this->markTestIncomplete('testHasQtyChanged not implemented.');
	}

/**
 * testUpdateQtyPreviousWhenQtyChange method
 *
 * @return void
 */
	public function testUpdateQtyPreviousWhenQtyChange() {
		$this->markTestIncomplete('testUpdateQtyPreviousWhenQtyChange not implemented.');
	}

/**
 * testUpdateInventoryStatusDateTime method
 *
 * @return void
 */
	public function testUpdateInventoryStatusDateTime() {
		$this->markTestIncomplete('testUpdateInventoryStatusDateTime not implemented.');
	}

/**
 * testUpdateHasRecordChanged method
 *
 * @return void
 */
	public function testUpdateHasRecordChanged() {
		$this->markTestIncomplete('testUpdateHasRecordChanged not implemented.');
	}

/**
 * testInventoryStatusNote method
 *
 * @return void
 */
	public function testInventoryStatusNote() {
		$this->markTestIncomplete('testInventoryStatusNote not implemented.');
	}

/**
 * testGetGlobalMinDaysLife method
 *
 * @return void
 */
	public function testGetGlobalMinDaysLife() {
		$this->markTestIncomplete('testGetGlobalMinDaysLife not implemented.');
	}

/**
 * testDoNotShip method
 *
 * @return void
 */
	public function testDoNotShip() {
		$this->markTestIncomplete('testDoNotShip not implemented.');
	}

/**
 * testPalletReferenceLookup method
 *
 * @return void
 */
	public function testPalletReferenceLookup() {
		$this->markTestIncomplete('testPalletReferenceLookup not implemented.');
	}

/**
 * testGetAvailableLocations method
 *
 * @return void
 */
	public function testGetAvailableLocations() {
		$this->markTestIncomplete('testGetAvailableLocations not implemented.');
	}

/**
 * testGetCapacity method
 *
 * @return void
 */
	public function testGetCapacity() {
		$this->markTestIncomplete('testGetCapacity not implemented.');
	}

/**
 * testLocationSpaceUsageOptions method
 *
 * @return void
 */
	public function testLocationSpaceUsageOptions() {
		$this->markTestIncomplete('testLocationSpaceUsageOptions not implemented.');
	}

/**
 * testHasCapacityInLocation method
 *
 * @return void
 */
	public function testHasCapacityInLocation() {
		$this->markTestIncomplete('testHasCapacityInLocation not implemented.');
	}

/**
 * testBatchLookup method
 *
 * @return void
 */
	public function testBatchLookup() {
		$this->markTestIncomplete('testBatchLookup not implemented.');
	}

/**
 * testFormatBatch method
 *
 * @return void
 */
	public function testFormatBatch() {
		$this->markTestIncomplete('testFormatBatch not implemented.');
	}

/**
 * testFormatLookup method
 *
 * @return void
 */
	public function testFormatLookup() {
		$this->markTestIncomplete('testFormatLookup not implemented.');
	}

}
