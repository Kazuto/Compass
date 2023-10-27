<?php

declare(strict_types=1);

namespace App\Actions\Theme;

use App\Actions\Action;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class LoadThemeConfigAction extends Action
{
    protected static string $description = 'Loading theme configuration from file';

    /**
     * @throws FileNotFoundException
     */
    public function execute(): array
    {
        return json_decode(File::get($this->getConfigPath()), true);
    }

    protected function getConfigPath(): string
    {
        return app()->basePath('theme.config.json');
    }
}
