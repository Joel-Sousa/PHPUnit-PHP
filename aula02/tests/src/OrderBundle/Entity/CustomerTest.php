<?php

namespace OrderBundle\Entity;

use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{

   /**
    * @test
    * @dataProvider customerAllowedDataProvider
    */

    public function testIsAllowedToOrder($isActive, $isBlocked, $expectedAllowed)
    {
        $customer = new Customer($isActive, $isBlocked, 'toto', '61999999999');

        $isAllowed = $customer->isAllowedToOrder();

        $this->assertEquals($expectedAllowed, $isAllowed);
    }

    public function customerAllowedDataProvider(){
        return [
            'sholdBeAllowedWhenIsActiveAndNotBlocked' => ['isActive' => true, 'isBlocked' => false, 'expectedAllowed' => true],
            'shouldNotBeAllowedWhenIsActiveButIsBlocked' => ['isActive' => true, 'isBlocked' => true, 'expectedAllowed' => false],
            'shouldNotBeAllowedWhenIsNotActive' => ['isActive' => false, 'isBlocked' => false, 'expectedAllowed' => false],
            'shoudNotBeAllowedWhenIsNotActiveAndIsBlocked' => ['isActive' => false, 'isBlocked' => true, 'expectedAllowed' => false],
        ];
    }
}
