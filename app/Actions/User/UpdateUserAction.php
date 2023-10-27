<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Action;
use App\Models\User;

class UpdateUserAction extends Action
{
    protected static string $description = 'Updating a user';

    public function execute(User $user, array $data): bool
    {
        return $user->update($data);
    }
}
