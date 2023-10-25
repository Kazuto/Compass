<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\General;

use App\Http\Controllers\Controller;
use App\Support\Logging\Raid;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

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
            $config = json_decode(File::get(app()->basePath().'/theme.config.json'), true);

            $colors = collect(Arr::get($config, 'colors'))
                ->mapWithKeys($this->colorGroupArray())
                ->collapse();
        } catch (\Throwable $exception) {
            $raid->error('Exception occurred', ['exception' => $exception->getMessage()]);
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
