<?php

namespace App\Helpers;

use App\Exceptions\ServiceNotFoundException;
use Illuminate\Support\Facades\App;

class ModuleServiceHelper
{
    public static function getService(string $serviceName)
    {
        if (App::bound($serviceName)) {
            return App::make($serviceName);
        }

        throw new ServiceNotFoundException($serviceName);
    }
}