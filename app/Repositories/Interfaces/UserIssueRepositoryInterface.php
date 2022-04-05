<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use App\Models\User;

interface UserIssueRepositoryInterface
{
  /**
   * 担当者の課題を全て取得する
   *
   * @param User $user
   * @param string $id
   * @return string
   */
  public function fetchAllIssues(User $user, string $projectId, string $assigneeId): string;

  /**
   * 日報用のデータを取得する
   *
   * @param User $user
   * @param string $date
   * @param Project $project
   * @return string
   */
  public function fetchUpdatedIssues(User $user, Project $project, string $date): string;
}