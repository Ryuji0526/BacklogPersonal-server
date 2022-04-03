<?php

namespace App\Repositories\Interfaces;

use PHPUnit\Util\Json;
use App\Models\User;
use Psr\Http\Message\StreamInterface;

interface UserIssueRepositoryInterface
{
  /**
   * 担当者の課題を全て取得する
   *
   * @param string $url
   * @param string $projectId
   * @param string $id
   * @return string
   */
  public function fetchAllIssues(string $url, string $apiKey, string $projectId, string $assigneeId): string;
}