<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use App\Repositories\Interfaces\UserIssueRepositoryInterface;
use GuzzleHttp\Client;

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
   * @param User $user
   * @param string $id
   * @return string
   */
  public function fetchAllIssues(User $user, string $projectId, string $assigneeId): string
  {
    $sendUrl = "{$user->backlog_url}/api/v2/issues?";
    $response = $this->client->request('GET', $sendUrl, [
      'query' => [
        'apiKey' => $user->api_key,
        'projectId[]' => $projectId,
        'assigneeId[]' => $assigneeId,
      ]
    ]);
    return $response->getBody()->getContents();
  }

  /**
   * その日更新されたデータを取得する
   *
   * @param User $user
   * @param Project $project
   * @param string $date
   * @return string
   */
  public function fetchUpdatedIssues(User $user, Project $project, string $date): string
  {
    $sendUrl = "{$user->backlog_url}/api/v2/issues?";
    // $sendUrl = "https://aidma-dev.backlog.com/api/v2/issues?";
    $response = $this->client->request('GET', $sendUrl, [
      'query' => [
        'apiKey' => $user->api_key,
        'projectId[]' => $project->project_id,
        'assigneeId[]' => $project->assignee_id,
        'updatedSince' => $date,
        'updatedUntil' => $date,
      ]
    ]);
    return $response->getBody()->getContents();
  }
}
