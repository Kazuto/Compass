<?php

namespace App\Http\Controllers\Settings\WhitelistAccess;

use App\Http\Controllers\Controller;
use App\Models\Settings\WhitelistAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class DeleteWhitelistAccessController extends Controller
{
    public function __invoke(WhitelistAccess $whitelistAccess): RedirectResponse
    {
        try {
            DB::transaction(function () use ($whitelistAccess) {
                $whitelistAccess->delete();

                Session::flash('success', 'The whitelist entry was deleted successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.whitelist.list'));
    }
}
