<?php

namespace App\Http\Services\Http;

use Exception;
use Illuminate\Support\Facades\Log;

class HttpException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        Log::error("#### XIMDEX - HTTP Exception: {$this->getMessage()} ####", [
            'exception' => $this,
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
        ]);
    }
}