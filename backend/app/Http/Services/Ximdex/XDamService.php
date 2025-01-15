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

        $this->token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmViNTlmNGM0MThhNjNmNzlmZTY1ZGI3OTQ1NWZiNDVjN2JlODZmOWVjMzFlZDkxMmM3MDk0YjJhZmY1YzQ2ZTM2M2VjZTVlMTQzNDc5ZjYiLCJpYXQiOjE3MzY3NjI5MDEuOTkzOTExOTgxNTgyNjQxNjAxNTYyNSwibmJmIjoxNzM2NzYyOTAxLjk5MzkyMzkwMjUxMTU5NjY3OTY4NzUsImV4cCI6MTc1MjQwMTMwMS45NzgxODMwMzEwODIxNTMzMjAzMTI1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.Avf-TaY2a3lAPvXH-U2t1VW2jVhsz2XNdVJSAr5ZnuDUH-YvmIh-JYZMonG3_HNr2k06OtXqoQZflxIbWpVT_7mSsBKx6rWunTTHoDufrXycro3AoVraEiBxG0F1kIEYaVe4a6ED1EVxC8dR73z6dUZKxnNcI-3zNEZch_7Nj1KLjTz8FB6nA547DuENd_7Nxxa4a6Z5wNgrLtuloy0D9kZ6Fc3EllnL3z9HNPc6Kh72zVSL227qJip3ob01opcNG0ssgGnu-Aku5GYmlpxLYPLxGdNmPwGhr3Ry2pMaTDxixbDWlLRRqVjUZfAB5v6NfkwxBHptM-jiM7B9Nu1RoxgawfHtAi91_z9LFUy64prino52Wlj2W3f8phc8XCphqmwMg2GdS0vDEog_vnhamVlEQVpKMujOyaLU3PVl4xIqNmt1roOCdUxyNgDZ32HpLzrpekJso_W-Y64Df752H1vd-Md61lIqihUQvNy44jaxtlPxp2qYpryepa1AQMS45T-wFFVw-9pu7fry4rAhmf9CjENEF5_rui9yOAkhi2WIxaJdYEmQUbjqJYppm78Az9wrT21dWyFZZfX09H6S8WmOnnE_I2Tf4J4aXvzVQpwujE30wC8oBCrK_Mfy2KByRzvYKwsrpiLqV-DVQQ2VG7oFURi1noSDAi-3H4CFbPQ";
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
