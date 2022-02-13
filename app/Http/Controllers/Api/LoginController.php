<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginFormRequest;

class LoginController extends Controller
{
    public function login(LoginFormRequest $request): JsonResponse
    {
        if (auth()->attempt($request->all())) {
            return response()->json(['message' => 'ok'], 200);
        }

        return response()->json(['message' => 'ユーザーが見つかりません。'], 422);
    }
}
