<?php

namespace App\Http\Services\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

class HttpClientService
{
    protected $client;

    /**
     * Puedes inyectar configuración si lo deseas, como tiempo de espera, headers globales, etc.
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client($config);
    }

    /**
     * Realiza una petición HTTP.
     */
    public function request(string $method, string $url, array $options = [], bool $json = true): array|Response
    {
        try {
            $response = $this->client->request($method, $url, $options);

            if (!$json) {
                return $response;
            }

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            return $data ?? [];
        } catch (RequestException $e) {
            // Aquí puedes manejar excepciones, logs u otras acciones
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}