<?php
declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\User;

interface UserIssueServiceInterface
{
  /**
   * 担当者の課題を全て取得する
   *
   * @param User $user
   * @return string
   */
  public function fetchMyAllIssues(User $user): string;

  /**
   * 日報に必要なデータを取得する
   * 
   * @return void
   */
  public function fetchAndSendTodaysUpdateIssues(): void;
}