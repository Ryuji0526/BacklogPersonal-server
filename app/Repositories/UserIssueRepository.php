<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserIssueRepositoryInterface;
use GuzzleHttp\Client;
use PHPUnit\Util\Json;
use Psr\Http\Message\StreamInterface;
use App\Modules\ApplicationLogger;

class UserIssueRepository implements UserIssueRepositoryInterface
{
  private $client;

  public function __construct()
  {
    $this->client = new Client();
  }

  /**
   * 担当者の課題を全て取得する
   *
   * @param string $url
   * @param string $projectId
   * @param string $id
   * @return string
   */
  public function fetchAllIssues(string $url, string $apiKey, string $projectId, string $assigneeId): string
  {
    $logger = new ApplicationLogger(__METHOD__);
    $sendUrl = "{$url}/api/v2/issues?";
    $response = $this->client->request('GET', $sendUrl, [
      'query' => [
        'apiKey' => $apiKey,
        'projectId[]' => $projectId,
        'assigneeId[]' => $assigneeId,
      ]
    ]);
    $logger->success();
    return $response->getBody()->getContents();
  }
}

