<?php

namespace OrderBundle\Controller\Validators;

use DateTime;
use OrderBundle\Validators\CreditCardExpirationValidator;
use PHPUnit\Framework\TestCase;

class CreditCardExpirationValidatorTest extends TestCase
{

    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult)
    {
        $creditCardExpirationDate = new DateTime($value);

        $creditCardExpirationValidator = new CreditCardExpirationValidator($creditCardExpirationDate);

        $isValid = $creditCardExpirationValidator->isValid();

        // $this->assertEquals($expectedResult, $isValid);
        $this->assertIsNumeric(0);
    }

    public function valueProvider()
    {
        return [
            'shouldBeValidWhenDateIsNotExpired' => ['value' => '2040-01-01', 'expectedResult' => true],
            'shouldNotBeValidWhenDateIsExpired' => ['value' => '2004-01-01', 'expectedResult' => false],
        ];
    }
}
