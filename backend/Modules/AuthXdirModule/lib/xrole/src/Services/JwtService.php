<?php

namespace Ximdex\Xrole\Services;

use Firebase\JWT\Key;
use Ximdex\Xrole\Contracts\JwtInterface;

class JwtService
{
    private $publicKey;

    private $jwt;

    public function __construct(JwtInterface $jwt, string $publicKey)
    {
        $this->jwt = $jwt;
        $this->publicKey = $publicKey;
    }

    public function verifyToken(string $jwtToken): ?array
    {
        return $this->jwt->decode($jwtToken, new Key($this->publicKey, 'RS256'));
    }
}
