<?php
namespace Ximdex\Xrole\Models;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Ximdex\Xrole\Contracts\JwtInterface;

class FirebaseJwt implements JwtInterface
{   
    protected $public_key;

    public function __construct($public_key)
    {
        $this->public_key = $public_key;
    }

    public function decode($jwtToken): ?array
    {
        try {
            $decoded = JWT::decode($jwtToken, new Key($this->public_key, 'RS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}