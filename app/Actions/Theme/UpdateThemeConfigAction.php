<?php

declare(strict_types=1);

namespace App\Actions\Theme;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class UpdateThemeConfigAction
{
    /**
     * @throws FileNotFoundException
     */
    public function execute(array $data): void
    {
        $configPath = app()->basePath('theme.config.json');

        if (File::missing($configPath)) {
            File::copy(app()->basePath('theme.config.example.json'), $configPath);
        }

        $file = File::get($configPath);

        $file = json_decode($file, true);

        collect($data)->dot()->each(function ($value, $key) use (&$file) {
            Arr::set($file, $key, str($value)->upper());
        });

        File::replace($configPath, json_encode($file, JSON_PRETTY_PRINT));
    }
}
