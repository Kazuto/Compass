<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\WhitelistAccess;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\WhitelistAccess;
use App\Support\Logging\Raid;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListWhitelistAccessController extends Controller
{
    public function __invoke(Request $request): View
    {
        return raid(
            'List Whitelist Access',
            fn (Raid $raid) => $this->handle(),
        );
    }

    private function handle(): View
    {
        return view('settings.whitelist_access.index', [
            'whitelistAccess' => WhitelistAccess::all(),
            'teams' => Team::all()->pluck('name', 'id'),
        ]);
    }
}
