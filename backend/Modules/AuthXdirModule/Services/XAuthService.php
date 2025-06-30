<?php

namespace Modules\AuthXdirModule\Services;

use App\Http\Services\Ximdex\XDamService;
use App\Http\Services\Ximdex\XDirService;

class XAuthService
{
    protected $xDamService;
    protected $xDirService;
    protected $service;

    public function __construct(XDamService $xDamService, XDirService $xDirService)
    {
        $this->xDamService = $xDamService;
        $this->xDirService = $xDirService;

        $this->service = config('ximdex.xdir.enabled') ? $this->xDirService : $this->xDamService;
    }

    public function performAction($params)  {
        try {
            if ($performAction = $params['action']) {
                $data = $params['data'];
                switch ($performAction) {
                    case 'login':
                        return $this->login($data);
                    case 'logout':
                        return $this->logout($data);
                    case 'whoami':
                        return $this->whoami($data);
                    default:
                        throw new \Exception('Invalid action');
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }


    private function login($data) {
        try {
            $response = $this->service->login($data['email'], $data['password']);
            $whoami = $this->service->whoami($response['access_token']);
            if (!isset($whoami['data']['access_token'])) {
                $whoami['data']['access_token'] = $response['access_token'];
            }
            return $whoami['data'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function logout($data) {
        try {
            $response = $this->service->logout($data['token']);
            return $response;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function whoami($data) {
        try {
            $response = $this->service->whoami($data['token']);
            return $response['data'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}