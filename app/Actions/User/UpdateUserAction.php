<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;

class UpdateUserAction
{
    public function execute(User $user, array $data): bool
    {
        return $user->update($data);
    }
}
