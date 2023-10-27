<?php

declare(strict_types=1);

namespace App\Actions\Theme;

use App\Actions\Action;
use App\Exceptions\CommandException;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Process\ExecutableFinder;

class RebuildThemeAction extends Action
{
    protected static string $description = 'Rebuilding stylesheets and scripts';

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

        if ($result->failed()) {
            throw CommandException::unsuccessful();
        }

        return true;
    }
}
