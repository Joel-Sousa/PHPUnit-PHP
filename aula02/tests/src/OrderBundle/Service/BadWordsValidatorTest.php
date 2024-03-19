<?php

namespace OrderBundle\Service;

use OrderBundle\Repository\BadWordsRepository;
use PHPUnit\Framework\TestCase;

class BadWordsValidatorTest extends TestCase
{

    /**
     * @dataProvider valueProvider
     */
    public function testHasBadWords($badWords, $value, $expectedValue)
    {

        // $badWordsRepository = new BadWordsRepositoryStub();
        $badWordsRepository = $this->createMock(BadWordsRepository::class);
        $badWordsRepository->method('findAllAsArray')
            ->willReturn($badWords);

        $badWordsValidator = new BadWordsValidator($badWordsRepository);

        $hasBadWords = $badWordsValidator->hasBadWords($value);

        $this->assertEquals($expectedValue, $hasBadWords);
    }

    public function valueProvider()
    {
        return [
            'sholdBeValidWhenValueIsBadWords' => [
                'badWords' => ['bobo', 'chule', 'manezao', 'miseravi'],
                'value' => 'Toto e um miseravi',
                'expectedResult' => true
            ],
            'sholdBeValidWhenValueIsNotBadWords' => [
                'badWords' => ['bobo', 'chule', 'manezao', 'miseravi'],
                'value' => 'Toto e bom',
                'expectedResult' => false
            ],
            'sholdNoFindWhenTextIsEmpty' => [
                'badWords' => ['bobo', 'chule', 'manezao', 'miseravi'],
                'value' => '',
                'expectedResult' => false
            ],
            'shouldNotFindWhenBadWordsListIsEmpty' => [
                'badWords' => [],
                'value' => 'Toto e bom',
                'expectedResult' => false
            ],
        ];
    }
}
