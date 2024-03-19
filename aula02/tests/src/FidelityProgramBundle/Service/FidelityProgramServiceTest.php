<?php

namespace FidelityProgramBundle\Service;

use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class FidelityProgramServiceTest extends TestCase
{

    public function testShouldSaveWhenReceivePoints()
    {

        $pointsRepository = $this->createMock(PointsRepository::class);
        $pointsRepository->expects($this->once())->method('save');

        // $pointsRepository = new PointsRepositorySpy();


        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn(100);

        $allMessages = [];
        $logger = $this->createMock(LoggerInterface::class);
        $logger->method('log')
            ->will($this->returnCallback(
                function ($message) use (&$allMessages) {
                    $allMessages[] = $message;
                }
            ));

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator, $logger);

        $customer = $this->createMock(Customer::class);
        $value = 50;

        $fidelityProgramService->addPoints($customer, $value);

        $expectedMessages = [
            'Checking points for customer',
            'Customer received points'
        ];

        $this->assertEquals($expectedMessages, $allMessages);
    }

    public function testShouldNotSaveWhenReceivePoints()
    {

        $pointsRepository = $this->createMock(PointsRepository::class);
        $pointsRepository->expects($this->never())->method('save');

        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn(0);

        $logger = $this->createMock(LoggerInterface::class);

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator, $logger);

        // Dummie
        $customer = $this->createMock(Customer::class);
        $value = 20;

        $fidelityProgramService->addPoints($customer, $value);

        // $this->assertTrue(true);
    }
    // Basicamente os Stubs são os dubles que simplesmente são configurados para retornar o valor desejado:
    // $stub->method('doSomething')->willReturn('foo');

    // Os mocks, são quando voce faz asserção no comportamento, ou seja, vc vai tentar garantir no duble 
    // que um método daquele objeto vai ser chamado ou não, aqui por exemplo, além de retornar o valor desejado estou 
    // garantindo que o método doSomething seja chamado pelo menos uma vez (usando o expects/once):
    // $mock->expects($this->once())->method('doSomething')->will($this->returnValue(true));
}
