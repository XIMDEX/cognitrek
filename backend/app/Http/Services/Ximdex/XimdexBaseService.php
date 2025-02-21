<?php

namespace App\Http\Services\Ximdex;

use App\Http\Services\Http\HttpClientService;
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

    }

    abstract protected function login($email, $password);

    abstract protected function logout();

    abstract protected function whoami($token);
    
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

    protected function isTokenExpired($token)
    {
        return false;
    }

    protected function setTokenCache($token)
    {
        Cache::put($this->tokenCacheKey, $token, $this->tokenTTL);
    }

}
