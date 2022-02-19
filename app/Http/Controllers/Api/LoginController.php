<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\LoginFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Modules\ApplicationLogger;

class LoginController extends Controller
{
    /**
     * ログイン処理
     * @param LoginFormRequest $request
     * @return JsonResponse
     */
    public function login(LoginFormRequest $request)
    {
        try {
            $logger = new ApplicationLogger(__METHOD__);
            $email = $request->email;
            $password = $request->password;
    
            $user = User::where('email', $email)->first();
    
            if (! $user || ! Hash::check($password, $user->password)) {
                $logger->write("mistake password");
                throw ValidationException::withMessages([
                    'email' => ['メールが違うか、パスワードが違うか'],
                ]);
            }
        } catch(\Throwable $e) {
            $logger->write($e->getMessage());
            $logger->exception($e);
            $logger->write("failed login");
            return response()->json('ログインに失敗しました', 400);
        }
        $logger->success();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(compact('token'), 200);
    }
}
