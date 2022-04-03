<?php
declare(strict_types=1);

namespace App\Http\Controllers\APi;

// require __DIR__ . '/vender/autoload.php';

use App\Http\Controllers\Controller;
use App\Modules\ApplicationLogger;
use Illuminate\Http\Request;
use App\Services\UserIssueService;
use Illuminate\Support\Facades\Auth;

class UserIssueController extends Controller
{
    private $userIssueService;

    public function __construct(UserIssueService $userIssueService)
    {
        $this->userIssueService = $userIssueService;
    }

    public function getMyIssues()
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $user =  Auth::user();
            $logger->write("自分の課題を全て取得します。");
            $issues = $this->userIssueService->fetchMyAllIssues($user);
            $logger->write($issues);
            // ddd($issues);
            return response()->json($issues, 200);
        } catch (\Throwable $e) {
            $logger->exception($e);
            return response()->json('課題の取得に失敗しました', 400);
        }
    }
}
