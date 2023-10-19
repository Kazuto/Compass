<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\WhitelistAccess;

use App\Actions\WhitelistAccess\StoreWhitelistAccessAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\WhitelistAccess\StoreWhitelistAccessRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class StoreWhitelistAccessController extends Controller
{
    public function __invoke(StoreWhitelistAccessRequest $request): RedirectResponse
    {
        return raid(
            'Store Whitelist Access',
            fn (Raid $raid) => $this->handle($request, $raid),
        );
    }

    private function handle(StoreWhitelistAccessRequest $request, Raid $raid): RedirectResponse
    {
        $raid->addContext('data', $request->validated());

        try {
            DB::transaction(function () use ($request, $raid) {
                $raid->debug('Calling Action', ['action' => StoreWhitelistAccessAction::class]);

                app(StoreWhitelistAccessAction::class)->execute($request->validated());

                Session::flash('success', 'The whitelist entry was added successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.whitelist.list'));
    }
}
