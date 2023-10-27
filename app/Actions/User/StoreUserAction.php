<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Action;
use App\Models\User;

class StoreUserAction extends Action
{
    protected static string $description = 'Creating a new user';

    public function execute(array $data): User
    {
        return User::create($data);
    }
}
