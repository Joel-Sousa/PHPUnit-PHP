<?php

namespace OrderBundle\Controller\Validators;

use OrderBundle\Validators\NumericValidator;
use PHPUnit\Framework\TestCase;

class NumericValidatorTest extends TestCase{

    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult){

            $numericValidator = new NumericValidator($value);
            
            $isValid = $numericValidator->isValid();
            
            $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider(){
        return [
            'shouldBeValidWhenValueIsNumber' => ['value' => 10, 'expectedResult' => true],
            'shouldBeValidWhenValueIsNumericString' => ['value' => '10', 'expectedResult' => true],
            'shouldBeValidWhenValueIsNotANumber' => ['value' => 'tst', 'expectedResult' => false],
            'shouldBeValidWhenValueIsEmpty' => ['value' => '', 'expectedResult' => false],
        ];
    }

}