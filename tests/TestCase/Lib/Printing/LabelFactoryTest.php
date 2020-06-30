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
use Cake\Core\Configure;

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
    public function tearDown(): void
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

        $testClasses = Configure::read('PrintLabelClasses');

        foreach ($testClasses as $k => $className ) {

                $LabelFactory = LabelFactory::create($className, 'james');

                $this->assertInstanceOf($className, $LabelFactory);
        }

    }



    public function testLabelFactoryThrows()
    {
        $bogusClass = '\App\Lib\Harhar';
        $expectedMessage = 'Cannot find ' . $bogusClass;
        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage($expectedMessage);
        LabelFactory::create($bogusClass, 'james');
    }

    public function testPrintCountIsCorrect()
    {
        $classMap = Configure::read('PrintLabelClasses');

        echo "\n";
        foreach ($classMap as $key => $value) {
            $expectedClass = $value;
            $labelFactory = LabelFactory::create($value, 'james');
            // echo $value . ' variablePages = "' . (string) $labelFactory->getVariablePages() . '"' . "\n";
            $this->assertInstanceOf($expectedClass, $labelFactory);
        }
    }
}
