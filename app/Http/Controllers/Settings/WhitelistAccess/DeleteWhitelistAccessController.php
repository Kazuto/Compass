<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\WhitelistAccess;

use App\Actions\WhitelistAccess\DeleteWhitelistAccessAction;
use App\Http\Controllers\Controller;
use App\Models\WhitelistAccess;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class DeleteWhitelistAccessController extends Controller
{
    public function __invoke(WhitelistAccess $whitelistAccess): RedirectResponse
    {
        return raid(
            'Deleting Whitelist Access',
            fn (Raid $raid) => $this->handle($whitelistAccess, $raid),
        );
    }

    private function handle(WhitelistAccess $whitelistAccess, Raid $raid): RedirectResponse
    {
        $raid->addContext('whitelistAccessId', $whitelistAccess->id);

        try {
            DB::transaction(function () use ($whitelistAccess, $raid) {
                $raid->debug('Calling Action', ['action' => DeleteWhitelistAccessAction::class]);

                app(DeleteWhitelistAccessAction::class)->execute($whitelistAccess);

                Session::flash('success', 'The whitelist entry was deleted successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.whitelist.list'));
    }
}
