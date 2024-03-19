<?php

namespace PaymentBundle\Service;

use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{

    private $array;

    public static function setupBeforeClass() : void
    {

    }

    public function testShouldBeFilled()
    {
        $this->array = ['hello' => 'world'];
        $this->assertNotEmpty($this->array);
    }

    public function testShouldBeEmpty()
    {
        $this->assertEmpty($this->array);  
    }
}
