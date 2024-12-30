<?php

namespace App\Services\LLM\Adapters;

use App\Services\Http\HttpClientService;
use Exception;
use Illuminate\Support\Facades\Cache;

abstract class XimdexBaseService
{
    protected $base_url;
    protected $login_url;
    protected $httpClient;
    protected $username;
    protected $password;

    protected $user;
    protected $token;
    protected $tokenCacheKey = 'ximdex_api_token'; 
    protected $tokenTTL = 3600;

    protected $authService = 'xdir';

    /**
     * @param string $user
     * @param string $pass
     * @param string $base_url
     * @param string|null $login_url
     * @param HttpClientService $httpClient
     */
    public function __construct( HttpClientService $httpClient)
    {
        $this->httpClient = $httpClient;

        $service = config("ximdex.{$this->authService}");
        $this->login_url =  $service['login_endpoint'];
        $this->username = $service['username'];
        $this->password = $service['password'];

    }
    /**
     * Checks if the user is currently authenticated.
     * It retrieves the token from cache and verifies if it is not expired.
     *
     * @return bool True if authenticated, false otherwise.
     */
    protected function checkAuth()
    {
        $token = Cache::get($this->tokenCacheKey);
        

        if (!$token || $this->isTokenExpired($token)) {
            $this->login($this->username, $this->password);
        } else {
            $this->token = $token;
        }

        return true;
    }

    public function login($username, $password) 
    { 
        try {
            $response = $this->httpClient->request('POST', $this->login_url, [
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ]
            ]);
        } catch (Exception $e) {
            throw new Exception("Error during login request: " . $e->getMessage(), $e->getCode(), $e);
        }

        if (empty($response['token'])) {
            throw new Exception("No token received from login.");
        } try {
            $response = $this->httpClient->request('POST', $this->login_url, [
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ]
            ]);
        } catch (Exception $e) {
            throw new Exception("Error during login request: " . $e->getMessage(), $e->getCode(), $e);
        }

    if (empty($response['token'])) {
        throw new Exception("No token received from login.");
    }

        Cache::put($this->tokenCacheKey, $this->token, $this->tokenTTL);
    }

    protected function isTokenExpired($token)
    {
        return false;
    }

}