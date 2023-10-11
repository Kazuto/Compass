<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\WhitelistAccess;

use App\Actions\WhitelistAccess\StoreWhitelistAccessAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhitelistAccessRequest;
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
                app(StoreWhitelistAccessAction::class)->execute($request->validated());

                Session::flash('success', 'The whitelist entry was added successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.whitelist.list'));
    }
}
