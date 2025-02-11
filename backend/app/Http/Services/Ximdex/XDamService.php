<?php

namespace App\Http\Services\Ximdex;

use App\Http\Services\Http\HttpClientService;
use Exception;
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
        $this->authService = $xdamService['auth'];
        $this->base_url = $xdamService['uri'];
        parent::__construct($httpClient);

        $this->token = env('XDAM_TOKEN');
    }

    private function damRequest($request, $method='GET', $body=[], $json=true)
    {
        // $this->checkAuth();

        try {
            $response = $this->httpClient->request($method, "{$this->base_url}/$request", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ],
                'json' => $body
            ], $json);
        } catch (Exception $e) {
            throw new Exception("Error fetching -- " . $e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    public function getResource($id)
    {
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
}
