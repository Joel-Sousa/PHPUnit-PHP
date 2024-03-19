<?php

namespace PaymentBundle\Service;

use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use PaymentBundle\Exception\PaymentErrorException;
use PaymentBundle\Repository\PaymentTransactionRepository;
use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{

    private $gateway;
    private $paymentTransactionRepository;
    private $paymentService;
    private $customer;
    private $item;
    private $creditCard;
    
    // Executa somente uma vez para cada classe de teste
    public static function setupBeforeClass() : void
    {

    }

    // Executa antes de cada teste
    public function setUp() : void
    {
        $this->gateway = $this->createMock(Gateway::class);
        $this->paymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);

        $this->paymentService = new PaymentService($this->gateway, $this->paymentTransactionRepository);

        $this->customer  = $this->createMock(Customer::class);
        $this->item = $this->createMock(Item::class);
        $this->creditCard = $this->createMock(CreditCard::class);
    }
    
    public function testShouldSaveWhenGatewayReturnOkWithRetries()
    {
        $this->gateway->expects($this->atLeast(3))
            ->method('pay')
            ->will($this->onConsecutiveCalls(false, false, true));

        $this->paymentTransactionRepository->expects($this->once())
            ->method('save');

        $this->paymentService->pay($this->customer, $this->item, $this->creditCard);
    }

    public function testShouldThrowExceptionGatewayFails()
    {
        $this->gateway->expects($this->atLeast(3))
            ->method('pay')
            ->will($this->onConsecutiveCalls(false, false, false));

        $this->paymentTransactionRepository->expects($this->never())
            ->method('save');

        $this->expectException(PaymentErrorException::class);

        $this->paymentService->pay($this->customer, $this->item, $this->creditCard);
    }

    // Ajuda a finalizar os testes
    public function tearDown() : void
    {
        unset($this->gateway);
    }
}
