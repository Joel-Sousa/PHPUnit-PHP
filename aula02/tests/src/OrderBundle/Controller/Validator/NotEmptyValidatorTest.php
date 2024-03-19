<?php

namespace OrderBundle\Controller\Validators;

use OrderBundle\Validators\NotEmptyValidator;
use PHPUnit\Framework\TestCase;

class NotEmptyValidatorTest extends TestCase{

    public function testShouldNotBeValid(){

        $emptyValue = "";

        $notEmptyValidator = new NotEmptyValidator($emptyValue);

        $isValid = $notEmptyValidator->isValid();

        $this->assertFalse($isValid);
    }

    public function testShouldBeValid(){

        $emptyValue = "tst";

        $notEmptyValidator = new NotEmptyValidator($emptyValue);

        $isValid = $notEmptyValidator->isValid();

        $this->assertTrue($isValid);
    }

    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult){

            $notEmptyValidator = new NotEmptyValidator($value);
            
            $isValid = $notEmptyValidator->isValid();
            
            $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider(){
        return [
            'shouldBeValidWhenValueIsNotEmpty' => ['value' => 'foo', 'expectedResult' => true],
            'shouldNotBeValidWhenValueIsNotEmpty' => ['value' => '', 'expectedResult' => false]
        ];
    }

}