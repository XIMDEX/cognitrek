<?php

namespace App\Http\Services\Ximdex;

use App\Http\Services\Http\HttpClientService;
use Illuminate\Support\Facades\Cache;
use Exception;

class XDirService extends XimdexBaseService
{

    public function __construct(HttpClientService $httpClient)
    {
        $xdirService = config('ximdex.xdir');
        $this->authService = $xdirService['auth'];
        $this->base_url = $xdirService['uri'];
        parent::__construct($httpClient);

    }

    public function login($email, $password)
    {
        try {
            $response = $this->httpClient->request('POST', $this->login_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'email' => $email,
                    'password' => $password,
                ]
            ]);
        } catch (Exception $e) {
            throw new Exception("Error during login request: " . $e->getMessage(), $e->getCode(), $e);
        }

        if (empty($response['token'])) {
            throw new Exception("No token received from login.");
        }

        $this->setTokenCache($response['token']);
    }

    public function logout()
    {
        try {
            $response = $this->httpClient->request('POST', $this->base_url . '/logout', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => []
            ]);
            if ($response['status'] == 'success') {
                Cache::forget($this->tokenCacheKey);
            }
        } catch (Exception $e) {
            throw new Exception("Error during logout request: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function whoami($token)
    {
        try {
            $response = $this->httpClient->request('GET', $this->base_url . '/me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ]
            ]);
            return $response;
        } catch (Exception $e) {
            throw new Exception("Error during whoami request: " . $e->getMessage(), $e->getCode(), $e);
        } 
    }
}
