<?php
App::uses('Carton', 'Model');

/**
 * Carton Test Case
 */
class CartonTest extends CakeTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.carton',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Carton = ClassRegistry::init('Carton');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Carton);

        parent::tearDown();
    }

    /**
     * testNotShipped method
     *
     * @return void
     */
    public function testNotShipped()
    {
        $this->markTestIncomplete('testNotShipped not implemented.');
    }

    public function testSelectAgainstFixture()
    {
        $record = $this->Carton->find('all', [
            'conditions' => [
                'Carton.pallet_id' => 1658,
            ],
        ]);
        echo print_r($record);
    }

    /**
     * testIsUniqueDate method
     *
     * @return void
     */
    public function testIsUniqueDate()
    {
        $this->markTestIncomplete('testIsUniqueDate not implemented.');
    }
}