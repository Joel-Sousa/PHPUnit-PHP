<?php

namespace PaymentBundle\Service;

use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;
use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{

    public function testShouldNotPayWhenAuthenticationFail()
    {

        $httpClient = $this->createMock(HttpClientInterface::class);

        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'invalid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                null
            ]
        ];

        $httpClient
            ->expects($this->once()) 
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay("toto", 1111222233334444, new \DateTime('now'), 100);

        $this->assertEquals(false, $paid);
    }

    public function testShouldNotPayWhenFailOnGateway()
    {
        
        $httpClient = $this->createMock(HttpClientInterface::class);
        
        $logger = $this->createMock(LoggerInterface::class);
    
        $user = 'test';
        $password = 'valid-password';
        $token = 'meu-token';
        $name = 'toto';
        $credit_card_number = 1111222233334444;
        $value = 100;
        $validity = new \DateTime('now');

        $gateway = new Gateway($httpClient, $logger, $user, $password);
        
        
        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                $token
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $credit_card_number,
                    'validity' => $validity,
                    'value' => $value,
                    'token' => $token
                ],
                ['paid' => false]
                ]
            ];
            
            
            $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));
            
            $logger->expects($this->once())
                ->method('log')
                ->with('Payment failed');

            $paid = $gateway->pay($name, $credit_card_number, $validity, $value);
            
            $this->assertEquals(false, $paid, 'MESSAGE!!!');
        }
        
    public function testShouldSuccessFullPayWhenGatewayReturnOK()
    {

        $httpClient = $this->createMock(HttpClientInterface::class);

        $validity = new \DateTime('now');
        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => 'test',
                    'password' => 'valid-password'
                ],
                'meu-token'
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => 'toto',
                    'credit_card_number' => 9999999999999999,
                    'validity' => $validity,
                    'value' => 100,
                    'token' => 'meu-token'
                ],
                ['paid' => true]
            ]
        ];

        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));

        $logger = $this->createMock(LoggerInterface::class);

        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay("toto", 9999999999999999, $validity, 100);

        $this->assertEquals(true, $paid);
    }

}

// O metodo at() levanta um erro pois vai ser removido na versao 10 do php unit
// public function shouldNotPayWhenFailOnGateway()
//     {
//         $httpClient = $this->createMock(HttpClientInterface::class);
//         $logger = $this->createMock(LoggerInterface::class);
//         $user = 'test';
//         $password = 'valid-password';
//         $gateway = new Gateway($httpClient, $logger, $user, $password);

//         $token = 'meu-token';
//         $httpClient
//             ->expects($this->at(0))
//             ->method('send')
//             ->willReturn($token);

//         $httpClient
//             ->expects($this->at(1))
//             ->method('send')
//             ->willReturn(['paid' => false]);

//         $logger
//             ->expects($this->once())
//             ->method('log')
//             ->with('Payment failed');

//         $name = 'Vinicius Oliveira';
//         $creditCardNumber = 5555444488882222;
//         $value = 100;
//         $validity = new \DateTime('now');
//         $paid = $gateway->pay(
//             $name,
//             $creditCardNumber,
//             $validity,
//             $value
//         );

//         $this->assertEquals(false, $paid);
//     }