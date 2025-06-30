<?php

namespace Modules\AuthXdirModule\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class XAuthController extends Controller
{
    public function login(Request $request)
    {
        
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $user = $this->useService('xauth_service', ['action' => 'login', 'data' => $validated]);
            if ($user) {
                return response()->json($user);
            }
            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function logout(Request $request)
    {
        
        $response = $this->useService('xauth_service', ['action' => 'login', 'data' => ['token' => $request->bearerToken()]]);
        return response()->json($response);
    }

    public function whoami(Request $request)
    {
        $response = $this->useService('xauth_service', ['action' => 'whoami', 'data' => ['token' => $request->bearerToken()]]);
        return response()->json($response);
    }
}
