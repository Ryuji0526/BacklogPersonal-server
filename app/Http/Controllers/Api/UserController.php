<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\LoginFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Modules\ApplicationLogger;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * ログイン済みユーザー取得処理
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json(compact('user'), 200);
    }

    /**
     * ユーザー登録
     *
     * @param LoginFormRequest $request
     * @return JsonResponse
     */
    public function register(LoginFormRequest $request)
    {
        $logger = new ApplicationLogger(__METHOD__);
        $logger->write('登録処理を行います');
        try {
            DB::transaction(function() use($request, $logger) {
                $request['password'] = Hash::make($request['password']);
                $user = User::create($request->all());
                event(new Registered($user));

                $logger->write('登録成功。ログイン処理を行います');
                $user->createToken('token')->plainTextToken;
                $logger->success();
                return response()->json(['user' => $user], 200);
            });
        } catch (\Throwable $e) {
            $logger->exception($e);
            return response()->json('新規登録に失敗しました', 400);
        }
    }

    /**
     * ログイン処理
     *
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

            if ($user['email_verified_at']) {
                $token = $user->createToken('token')->plainTextToken;
            } else {
                $logger->write('未認証のユーザーです');
                throw new \Exception();
            }

            $logger->success();
            return response()->json(compact('token'), 200);
        } catch(\Throwable $e) {
            $logger->exception($e);
            return response()->json('ログインに失敗しました', 400);
        }
    }

    /**
     * ログアウト処理
     *
     * @return JsonResponse
     */
    public function logout() {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('ログアウト処理を開始します。');
            Auth::logout();
            $message = 'ログアウトしました';
            $status = 200;
            $logger->write('ログアウト処理を正常に行いました');
        } catch(\Throwable $e) {
            $logger->exception($e);
            $message = 'ログアウトに失敗しました';
            $status = 400;
        }
        return response()->json(['message' => $message], $status);
    }
}