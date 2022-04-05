<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use GuzzleHttp\Client;
use App\Modules\ApplicationLogger;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
  public function fetchAuthorizedUsers(): Collection
  {
    return User::whereNotNull('email_verified_at')->get();
  }
}

