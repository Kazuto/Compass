<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;

class StoreUserAction
{
    public function execute(array $data): User
    {
        return User::create($data);
    }
}
