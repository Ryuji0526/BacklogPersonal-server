<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Modules\ApplicationLogger;
use App\Services\Interfaces\UserIssueServiceInterface;
use App\Repositories\UserIssueRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReport;
use Carbon\Carbon;

class UserIssueService implements UserIssueServiceInterface
{
  private $userIssueRepository;
  private $userRepository;

  public function __construct(UserIssueRepository $userIssueRepository, UserRepository $userRepository)
  {
    $this->userIssueRepository = $userIssueRepository;
    $this->userRepository = $userRepository;
  }

  /**
   * 担当者の課題を全て取得する
   *
   * @param User $user
   * @return string
   */
  public function fetchMyAllIssues(User $user): string
  {
    $logger = new ApplicationLogger(__METHOD__);
$response = $this->userIssueRepository->fetchAllIssues($user, '207680', '581170');
  $logger->success();
    return $response;
  }

  /**
   * 日報用データを返し、メールを送信します。
   *
   * @return void
   */
  public function fetchAndSendTodaysUpdateIssues(): void
  {
    $logger = new ApplicationLogger(__METHOD__);
    $users = $this->userRepository->fetchAuthorizedUsers();
    $yesterday = Carbon::yesterday()->format("Y-m-d");
    foreach ($users as $user) {
      $sendData = [];
      foreach ($user->projects as $project) {
        $issues = $this->userIssueRepository->fetchUpdatedIssues($user, $project, $yesterday);
        $issues = json_decode($issues);
        $sendData[] = [
          'projectIssues' => $issues,
          'projectName' => 'Meet-in'
        ];
      }
      Mail::to($user->email)->send(new DailyReport($sendData, true));
    }
    $logger->success();
  }
}