<?php

namespace App\Http\Controllers\Settings\WhitelistAccess;

use App\Http\Controllers\Controller;
use App\Models\WhitelistAccess;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListWhitelistAccessController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('settings.whitelist_access.index', [
            'whitelistAccess' => WhitelistAccess::all(),
        ]);
    }
}
