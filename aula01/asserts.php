<?php 
namespace Asserts;

class Asserts{

    public function assertEquals($expectedValue, $actualValue){
        
        if($expectedValue !== $actualValue){
            $message = 'Expected:' . $expectedValue . ' but got ' . $actualValue;
            throw new \Exception($message);
        }

        echo "Test passed \n";

    }
}