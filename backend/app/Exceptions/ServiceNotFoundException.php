<?php

namespace App\Exceptions;

use Exception;

class ServiceNotFoundException extends Exception
{
    public function __construct($serviceName)
    {
        parent::__construct("Servicio '$serviceName' is  not registerd");
    }
}