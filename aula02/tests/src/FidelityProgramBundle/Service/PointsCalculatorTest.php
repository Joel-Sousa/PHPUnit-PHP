<?php

namespace FidelityProgramBundle\Service;

use PHPUnit\Framework\TestCase;

class PointsCalculatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
    public function testPointsToReceive($value, $expectedPoints)
    {
        $pointsCalculator = new PointsCalculator();

        $points = $pointsCalculator->calculatePointsToReceive($value);

        $this->assertEquals($expectedPoints, $points);
    }

    public function valueProvider()
    {
        return [
            'value0' => ['value' => 30, 'expectedResult' => 0],
            'value55' => ['value' => 55, 'expectedResult' => 1100],
            'value77' => ['value' => 77, 'expectedResult' => 2310],
            'value111' => ['value' => 111, 'expectedResult' => 5550],
        ];
    }
}
