<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Modules\ApplicationLogger;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
  /**
   * メール認証
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function __invoke(Request $request):RedirectResponse
  {
    try {
      $logger = new ApplicationLogger(__METHOD__);
      $user = User::find($request->route('id'));

      if ($user->hasVerifiedEmail()) {
        $logger->write('既に認証済みのユーザーです。 ID:' . $user['id']);
        return redirect(env('ORIGIN_NAME') . '/');
      }

      if ($user->markEmailAsVerified()) {
        $logger->write('認証処理を開始します' . $user['id']);
        event(new Verified($user));
      }

      $logger->success();
      return redirect(env('ORIGIN_NAME') . '/');

    } catch (\Exception $e) {
      $logger->exception($e);
    }
  }
}