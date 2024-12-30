<?php

namespace App\Services\LLM\Adapters;

use App\Services\Http\HttpClientService;
use Exception;

class XDamService extends XimdexBaseService
{

    public function __construct(HttpClientService $httpClient)
    {
        $xdamService = config('ximdex.xdam');
        $this->authService = $xdamService['auth_name'];
        $this->base_url = $xdamService['uri'];
        parent::__construct($httpClient);
    }

    public function getResource($id)
    {
        $this->checkAuth();

        try {
            $response = $this->httpClient->request('GET', "{$this->base_url}/resources/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ]
            ]);
        } catch (Exception $e) {
            throw new Exception("Error fetching resource {$id}: " . $e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }
}