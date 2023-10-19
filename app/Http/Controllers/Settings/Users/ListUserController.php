<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Logging\Raid;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function view;

class ListUserController extends Controller
{
    public function __invoke(Request $request): View
    {
        return raid(
            'List Users',
            fn (Raid $raid) => $this->handle(),
        );
    }

    private function handle(): View
    {
        return view('settings.users.index', [
            'users' => User::all(),
        ]);
    }
}
