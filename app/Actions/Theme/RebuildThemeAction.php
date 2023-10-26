<?php

declare(strict_types=1);

namespace App\Actions\Theme;

use App\Exceptions\CommandException;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Process\ExecutableFinder;

class RebuildThemeAction
{
    const PATHS = ['/usr/local/bin', '/usr/bin'];

    /**
     * @throws CommandException
     */
    public function execute(): bool
    {
        $command = [
            (new ExecutableFinder())->find('yarn', 'yarn', self::PATHS),
            'build',
        ];

        $result = Process::path(app()->basePath())->run($command);

        if (! $result->successful()) {
            throw CommandException::unsuccessful();
        }

        return true;
    }
}
