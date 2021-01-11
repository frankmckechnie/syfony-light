<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class DefaultService{

    private $gifts = ['car', 'monkey', 'money', 'phone', 'mic', 'bike', 'glass', 'computer', 'pen', 'ball'];

    public function __construct($name, $adminEmail, $service)
    {
       dump($service);
    }

}