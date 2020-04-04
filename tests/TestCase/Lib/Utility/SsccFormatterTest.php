<?php

App::import('Lib/Utility', 'SsccFormatter');

/**
 * Carton Test Case
 */
class SsccFormatterTest extends CakeTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * testNotShipped method
     *
     * @return void
     */
    public function testSsccFormatterWorks()
    {
        $ssccNumber = '093115790028451382';
        $expectedNumber = '0 9311579 002845138 2';
        $sscc = new SsccFormatter($ssccNumber);
        $this->assertEqual($sscc->sscc, $expectedNumber);
    }

    public function testSsccFormatterIsNullOnShortSscc()
    {
        $ssccNumber = '09311579002845138'; // 17 digits
        $expectedNumber = null;
        $sscc = new SsccFormatter($ssccNumber);
        $this->assertEqual($sscc->sscc, $expectedNumber);

        $ssccNumber = '0931157900284513829'; // 19 digits

        $sscc = new SsccFormatter($ssccNumber);
        $this->assertEqual($sscc->sscc, $expectedNumber);
    }

    public function testReturnsNullWhenSsccIsNan()
    {
        $ssccNumber = 'abcabc';
        $expectedNumber = null;
        $sscc = new SsccFormatter($ssccNumber);
        $this->assertEqual($sscc->sscc, $expectedNumber);
    }

    public function testPassedNullReturnsNull()
    {
        $ssccNumber = null;
        $expectedNumber = null;
        $sscc = new SsccFormatter($ssccNumber);
        $this->assertEqual($sscc->sscc, $expectedNumber);
    }
}