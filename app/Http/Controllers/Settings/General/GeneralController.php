<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\General;

use App\Actions\Theme\LoadThemeConfigAction;
use App\Http\Controllers\Controller;
use App\Support\Logging\Raid;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Session;
use Throwable;

class GeneralController extends Controller
{
    public function __invoke(): View
    {
        return raid(
            'Show general information page',
            fn (Raid $raid) => $this->handle($raid)
        );
    }

    private function handle(Raid $raid): View
    {
        $colors = [];

        try {
            $config = app(LoadThemeConfigAction::class)->execute();

            $colors = collect(Arr::get($config, 'colors'))
                ->mapWithKeys($this->colorGroupArray())
                ->collapse();
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Error loading theme config!');
        }

        return view('settings.general.index', ['colors' => $colors]);
    }

    private function colorArray($group): Closure
    {
        return function ($value, $key) use ($group) {
            return [
                'bg-'.$group.'-'.$key => $value,
            ];
        };
    }

    private function colorGroupArray(): Closure
    {
        return function ($colors, $group) {
            return [
                $group => collect($colors)->mapWithKeys($this->colorArray($group)),
            ];
        };
    }
}
