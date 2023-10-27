<?php

declare(strict_types=1);

namespace App\Actions\Theme;

use App\Actions\Action;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class UpdateThemeConfigAction extends Action
{
    protected static string $description = 'Saving changes to theme configuration file';

    /**
     * @throws FileNotFoundException
     */
    public function execute(array $data): void
    {
        $configPath = $this->getConfigPath();

        if (File::missing($configPath)) {
            File::copy($this->getConfigExamplePath(), $configPath);
        }

        $file = File::get($configPath);

        $file = json_decode($file, true);

        collect($data)->dot()->each(function ($value, $key) use (&$file) {
            Arr::set($file, $key, str($value)->upper());
        });

        File::replace($configPath, json_encode($file, JSON_PRETTY_PRINT));
    }

    protected function getConfigPath(): string
    {
        return app()->basePath('theme.config.json');
    }

    protected function getConfigExamplePath(): string
    {
        return app()->basePath('theme.config.example.json');
    }
}
