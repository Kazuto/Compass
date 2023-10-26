<?php

declare(strict_types=1);

namespace App\Actions\Theme;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class LoadThemeConfigAction
{
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
