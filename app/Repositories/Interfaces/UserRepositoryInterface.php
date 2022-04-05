<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
  /**
   * 担当者の課題を全て取得する
   *
   * @return Collection
   */
  public function fetchAuthorizedUsers(): Collection;
}