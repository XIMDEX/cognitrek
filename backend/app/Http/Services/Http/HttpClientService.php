<?php

namespace App\Http\Services\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class HttpClientService
{
    protected $client;

    /**
     * Puedes inyectar configuración si lo deseas, como tiempo de espera, headers globales, etc.
     */
    public function __construct(array $config = ['timeout' => 300, 'connect_timeout' => 60])
    {
        $this->client = new Client($config);
    }

    /**
     * Realiza una petición HTTP.
     */
    public function request(string $method, string $url, array $options = [], bool $json = true): array|Response
    {
        try {
            if (isset($options['multipart']) && is_array($options['multipart'])) {
                foreach ($options['multipart'] as &$part) {
                    if (isset($part['contents']) && is_string($part['contents']) && file_exists($part['contents'])) {
                        $part['contents'] = fopen($part['contents'], 'r');
                    }
                }
            }
            $response = $this->client->request($method, $url, $options);

            if (!$json) {
                return $response;
            }

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            return $data ?? [];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                echo $e->getResponse()->getBody()->getContents();
            }

            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getCurlCommand(Request $request, array $options): string
    {
        $method = strtoupper($request->getMethod());
        $url = (string) $request->getUri();
        $headers = $request->getHeaders();
        $body = $request->getBody()->getContents();

        $curlCommand = "curl -X {$method} '{$url}'";

        foreach ($headers as $name => $values) {
            foreach ($values as $value) {
                $curlCommand .= " -H '{$name}: {$value}'";
            }
        }

        if (!empty($body)) {
            $curlCommand .= " --data '{$body}'";
        }

        return $curlCommand;
    }
}
