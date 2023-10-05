<?php

namespace App\Http\Controllers\Settings\WhitelistAccess;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhitelistAccessRequest;
use App\Models\Settings\WhitelistAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class StoreWhitelistAccessController extends Controller
{
    public function __invoke(StoreWhitelistAccessRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                WhitelistAccess::create($request->validated());

                Session::flash('success', 'The whitelist entry was added successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.whitelist.list'));
    }
}
