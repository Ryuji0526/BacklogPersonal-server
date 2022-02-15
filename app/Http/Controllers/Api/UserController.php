<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * ログイン済みユーザー取得処理
     * @param Request $request
     * @return JsonResponse
     */
    public function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json(compact('user'), 200);
    }
}