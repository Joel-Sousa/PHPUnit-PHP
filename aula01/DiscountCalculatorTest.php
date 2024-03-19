<?php

use Asserts\Asserts;

// class DiscountCalculatorTest extends Asserts{
class DiscountCalculatorTest{

    public function shouldApplyWhenValueIsAboveTheMinimumTest(){
        $discountCalculator = new DiscountCalculator();

        $totalValue = 130;

        $totalWithDiscount = $discountCalculator->apply($totalValue);

        $expectedValue = 130;
        $this->assertEquals($expectedValue, $totalWithDiscount);
    }

    public function shouldNotApplyWhenValueIsBellowTheMinimumTest(){
        $discountCalculator = new DiscountCalculator();

        $totalValue = 90;

        $totalWithDiscount = $discountCalculator->apply($totalValue);

        $expectedValue = 90;
        $this->assertEquals($expectedValue, $totalWithDiscount);
    }

    public function assertEquals($expectedValue, $actualValue){
        
        if($expectedValue !== $actualValue){
            $message = 'Expected:' . $expectedValue . ' but got ' . $actualValue;
            throw new \Exception($message);
        }

        echo "Test passed \n";
    }
}