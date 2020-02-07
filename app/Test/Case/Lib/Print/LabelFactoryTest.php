<?php

App::import('Lib/Print', 'LabelFactory');
App::import('Lib/Exception', 'MissingConfigurationException');
App::uses('GlabelSample', 'Lib/Print/Glabel');
App::uses('CustomLabel', 'Lib/Print/Glabel');
App::uses('ShippingLabel', 'Lib/Print/Glabel');
App::uses('CrossdockLabel', 'Lib/Print/Glabel');
App::uses('ShippingLabelsGeneric', 'Lib/Print/Glabel');
App::uses('SampleLabel', 'Lib/Print/Glabel');

/**
 * Carton Test Case
 */
class LabelFactoryTest extends CakeTestCase
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
    public function testLabelFactoryWorks()
    {
        $LabelFactory = LabelFactory::create('glabelSampleLabels');
        $expectedClass = 'GlabelSample';
        $this->assertInstanceOf($expectedClass, $LabelFactory);
    }

    public function testLabelFactoryThrows()
    {
        $bogusAction = 'bogusAction';
        $expectedMessage = 'Cannot find Lib/Print class for ' . $bogusAction;
        $this->expectException(MissingConfigurationException::class, $expectedMessage);
        LabelFactory::create($bogusAction);
    }

    public function testAllClassesExist()
    {
        $bogusActions = LabelFactory::$actionToClassMap;

        foreach ($bogusActions as $key => $value) {
            $expectedClass = $value;
            $LabelFactory = LabelFactory::create($key);
            $this->assertInstanceOf($expectedClass, $LabelFactory);
        }
    }

    public function testPrintCountIsCorrect()
    {
        $classMap = LabelFactory::$actionToClassMap;
        echo "\n";
        foreach ($classMap as $key => $value) {
            $expectedClass = $value;
            $labelFactory = LabelFactory::create($key);
            echo $key . ':' . $value . ' variablePages = "' . (string) $labelFactory->getVariablePages() . '"' . "\n";
            $this->assertInstanceOf($expectedClass, $labelFactory);
        }
    }
}