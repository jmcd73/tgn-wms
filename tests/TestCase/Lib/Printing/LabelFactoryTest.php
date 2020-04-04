<?php

namespace App\Test\TestCase\Lib\Printing;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\Glabel\CrossdockLabel;
use App\Lib\PrintLabels\Glabel\CustomLabel;
use App\Lib\PrintLabels\Glabel\GlabelSample;
use App\Lib\PrintLabels\Glabel\SampleLabel;
use App\Lib\PrintLabels\Glabel\ShippingLabel;
use App\Lib\PrintLabels\Glabel\ShippingLabelGeneric;
use App\Lib\PrintLabels\LabelFactory;
use Cake\Log\LogTrait;
use Cake\TestSuite\TestCase;

/**
 * Carton Test Case
 */
class LabelFactoryTest extends TestCase
{
    use LogTrait;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown():void
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

        $expectedClass = '\App\Lib\PrintLabels\Glabel\GlabelSample';

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