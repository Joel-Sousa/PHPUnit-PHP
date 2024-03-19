<?php

namespace OrderBundle\Service;

use OrderBundle\Repository\BadWordsRepositoryInterface;

class BadWordsRepositoryStub implements BadWordsRepositoryInterface{
// class BadWordsRepositoryStub {

    public function findAllAsArray(){
        return ['bobo', 'chule', 'manezao', 'miseravi'];
    }

}