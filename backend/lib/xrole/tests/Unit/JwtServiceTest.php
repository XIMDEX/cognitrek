<?php

use Firebase\JWT\JWT;
use PHPUnit\Framework\TestCase;
use Ximdex\Xrole\Services\JwtService;
use Ximdex\Xrole\Contracts\JwtInterface;
use Firebase\JWT\Key;
use Ximdex\Xrole\Models\FirebaseJwt;

class JwtServiceTest extends TestCase
{
    private $jwt;
    private $jwtService;
    private $publicKey;
    private $privateKey;

    protected function setUp(): void
    {
        $this->publicKey  = file_get_contents(__DIR__ . '/tests/public_key_test.pem');
        $this->privateKey = file_get_contents(__DIR__ . '/tests/private_key_test.pem');
        if (!$this->isValidPrivateKey('../private_key.pem')) {
            throw new \Exception('Invalid private key');
        }
        $this->jwt        = new FirebaseJwt($this->publicKey);
        $this->jwtService = new JwtService($this->jwt, $this->publicKey);
    }

    public function testVerifyToken()
    {
        $payload = ['user_id' => 1];
        openssl_pkey_get_private($this->privateKey);
        return $res = openssl_pkey_get_private($this->privateKey);
        $jwtToken = JWT::encode($payload, $this->privateKey, 'RS256');

        $decodedToken = $this->jwtService->verifyToken($jwtToken);

        $this->assertEquals($payload, (array) $decodedToken);
    }

    private function isValidPrivateKey($privateKey)
{
    $res = openssl_pkey_get_private($privateKey);
    if ($res === false) {
        // Private key is invalid
        return false;
    }

    // Don't forget to free the key resource
    openssl_pkey_free($res);

    // Private key is valid
    return true;
}
}
