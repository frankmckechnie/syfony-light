<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class GiftsService{

    private $gifts = ['car', 'monkey', 'money', 'phone', 'mic', 'bike', 'glass', 'computer', 'pen', 'ball'];

    public function __construct(LoggerInterface $logger)
    {
        $logger->info('Gifts where randomized');
        shuffle($this->gifts);
    }

    public function getGifts(){
        return $this->gifts;
    }

    public function setGifts(array $gifts){
        $this->gifts = $gifts;
    }

}