<?php

namespace App\Http\Services\Ximdex;

use App\Http\Services\Http\HttpClientService;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class XDamService extends XimdexBaseService
{

    protected const MIMETYPES = [
        'application/pdf' => 'pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
    ];

    public function __construct(HttpClientService $httpClient)
    {
        $xdamService = config('ximdex.xdam');
        parent::__construct($httpClient);
        $this->authService = $xdamService['auth'];
        $this->base_url = $xdamService['uri'];
        $this->login_url =  $xdamService['login_endpoint'];

        // $this->token = $token ?? env('XDAM_TOKEN');
    }

    public function login($email, $password)
    {
        try {
            $response = $this->httpClient->request('POST', $this->login_url, [
                'json' => [
                    'email' => $email,
                    'password' => $password,
                ]
            ]);
        } catch (Exception $e) {
            throw new Exception("Error during login request: " . $e->getMessage(), $e->getCode(), $e);
        }

        if (empty($response['data']['access_token'])) {
            throw new Exception("No token received from login.");
        }

        $this->setTokenCache($response['data']['access_token']);
        return $response['data'];
    }

    public function logout()
    {
        try {
            $response = $this->httpClient->request('POST', $this->base_url . '/user/logout', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
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
            $response = $this->httpClient->request('GET', $this->base_url . '/user/me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);
            return $response;
        } catch (Exception $e) {
            throw new Exception("Error during whoami request: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    private function damRequest($request, $method='GET', $body=[], $json=true)
    {
        if ($this->checkAuth() === false) {
            throw new Exception("Error fetching -- Not authenticated");
        }
        try {
            $params  = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ],
                'json' => $body
            ];
            $response = $this->httpClient->request($method, "{$this->base_url}/$request", $params, $json);
        } catch (Exception $e) {
            throw new Exception("Error fetching -- " . $e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    public function getResource($id)
    {
        if ($this->checkAuth() === false) {
            throw new Exception("Error fetching resource -- Not authenticated");
        }
        try {
            $dam_resource = $this->damRequest('resource/'.$id);
            if ($dam_resource) {
                $dam_file = $dam_resource['files'][count($dam_resource['files']) - 1];
                $dam_url = $dam_file['dam_url'];
                $dam_mime = $dam_file['mime_type'];

                $ext = $this->getMimeType($dam_mime);

                if (!$ext) {
                    throw new \Exception("The resource type cannot be processed");
                }
                $response = $this->damRequest('resource/download/'.$dam_url, 'GET', [], false);
                $fileContent = $response->getBody()->getContents();
                $path_file = "public/$id/file.$ext";
                Storage::put($path_file, $fileContent);
                $fileContent = null;
            }
        } catch (Exception $e) {
            throw new Exception("Error fetching resource {$id}: " . $e->getMessage(), $e->getCode(), $e);
        }

        return [
            'path' => storage_path("app/$path_file"),
            'type' => $ext,
            'output' => storage_path('app/public/'.$id),
            'lang' => $dam_resource['data']['description']['lang']
        ];
    }

    public function getMimeType($mimetype)
    {
        if ($mimetype == 'application/pdf') return 'pdf';
        if ($mimetype == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') return 'docx';
        return false;
    }

    private function createTmpFile($id, $ext) {
        $tempFile = tempnam(sys_get_temp_dir(), $id);
        $tempFileWithExtension = $tempFile . '.' . $ext;
        rename($tempFile, $tempFileWithExtension);
        return $tempFileWithExtension;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
}
