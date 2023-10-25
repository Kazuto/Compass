<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\General;

use App\Actions\Theme\RebuildThemeAction;
use App\Actions\Theme\UpdateThemeConfigAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\General\ThemeRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Throwable;

class RebuildThemeController extends Controller
{
    public function __invoke(ThemeRequest $request): RedirectResponse
    {
        return raid(
            'Rebuild theme',
            fn (Raid $raid) => $this->handle($request, $raid)
        );
    }

    private function handle(ThemeRequest $request, Raid $raid): RedirectResponse
    {
        try {
            $raid->debug('Updating theme config...', ['action' => UpdateThemeConfigAction::class]);

            app(UpdateThemeConfigAction::class)->execute($request->validated());
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'There was a problem saving the configuration.');

            return to_route('settings.general.index');
        }

        try {
            $raid->debug('Rebuilding theme...', ['action' => RebuildThemeAction::class]);

            app(RebuildThemeAction::class)->execute();
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'There was a problem rebuilding the theme.');

            return to_route('settings.general.index');
        }

        Session::flash('success', 'Your theme has been rebuilt.');

        return to_route('settings.general.index');
    }
}
