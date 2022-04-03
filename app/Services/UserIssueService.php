<?php
declare(strict_types=1);

namespace App\Services;

use PHPUnit\Util\Json;
use App\Models\User;
use App\Modules\ApplicationLogger;
use App\Services\Interfaces\UserIssueServiceInterface;
use App\Repositories\UserIssueRepository;
use Psr\Http\Message\StreamInterface;

class UserIssueService implements UserIssueServiceInterface
{
  private $userIssueRepository;

  public function __construct(UserIssueRepository $userIssueRepository)
  {
    $this->userIssueRepository = $userIssueRepository;
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
$response = $this->userIssueRepository->fetchAllIssues('https://aidma-dev.backlog.com', '9IsMC4yHy1vk0M6rEEPVILCx6NMOJEb6EUw5dpmkf8D4LJDJwZlpmXQdsrfuurfp', '207680', '581170');
  $logger->success();
    return $response;
  }
}