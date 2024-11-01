<?php

namespace OrderBundle\Controller\Validators;

use OrderBundle\Validators\CreditCardNumberValidator;
use PHPUnit\Framework\TestCase;

class CreditCardNumberValidatorTest extends TestCase{

    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult){

            $creditCardNumberValidator = new CreditCardNumberValidator($value);
            
            $isValid = $creditCardNumberValidator->isValid();
            
            $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider(){
        return [
            'shouldBeValidWhenValueIsACreditCard' => ['value' => 4928148506666302, 'expectedResult' => true],
            'shouldBeValidWhenValueIsACreditCardAsString' => ['value' => '4928148506666302', 'expectedResult' => true],
            'shouldBeValidWhenValueIsANotACreditCard' => ['value' => '123', 'expectedResult' => false],
            'shouldBeValidWhenValueIsEmpty' => ['value' => '', 'expectedResult' => false],
        ];
    }

}