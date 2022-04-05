<?php
declare(strict_types=1);

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Modules\ApplicationLogger;
use App\Services\UserIssueService;
use Illuminate\Support\Facades\Auth;

class UserIssueController extends Controller
{
    private $userIssueService;

    public function __construct(UserIssueService $userIssueService)
    {
        $this->userIssueService = $userIssueService;
    }

    /**
     * 自分の課題を全て取得
     *
     * @return void
     */
    public function getMyIssues()
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $user =  Auth::user();
            $logger->write("自分の課題を全て取得します。");
            $issues = $this->userIssueService->fetchMyAllIssues($user);
            return response()->json($issues, 200);
        } catch (\Throwable $e) {
            $logger->write($e->getMessage());
            return response()->json('課題の取得に失敗しました', 400);
        }
    }
}
