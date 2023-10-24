<?php

declare(strict_types=1);

namespace App\Support\Logging;

use Illuminate\Log\LogManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Stringable;

class Raid
{
    public function __construct(
        protected LogManager $logger,
        protected array $context = [],
        protected ?string $description = '',
    ) {
        $this->defaultContext();
    }

    public static function new(string $description = null): self
    {
        return new self(
            logger: new LogManager(app()),
            description: $description
        );
    }

    public function start(string $message, array $context = []): static
    {
        $this->info('START - '.$message, $context);

        return $this;
    }

    public function end(string $message, array $context = []): void
    {
        $this->info('END - '.$message, $context);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->prepareContext($context);

        $this->logger->debug($this->message($message), $this->context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->prepareContext($context);

        $this->logger->info($this->message($message), $this->context);
    }

    public function error(string $message, array $context = [], bool $unset = true): void
    {
        $this->prepareContext($context);

        $this->logger->error($this->message($message), $this->context);

        if ($unset) {
            $this->unsetContext($context);
        }
    }

    public function addContext($key, $value): static
    {
        Arr::set($this->context, $key, $value);

        return $this;
    }

    public function removeContext($key): void
    {
        Arr::forget($this->context, $key);
    }

    private function getLineFromBacktrace(): string
    {
        $backtrace = collect(debug_backtrace())->filter(function ($item) {
            return Arr::get($item, 'class') === self::class;
        })->last();

        return (string) Arr::get($backtrace, 'line');
    }

    private function message(string $message): string
    {
        return str($message)
            ->when(filled($this->description), function (Stringable $string) {
                return $string->prepend($this->description, ' - ');
            })
            ->toString();
    }

    private function defaultContext(): void
    {
        $origin = collect(debug_backtrace())
            ->filter(function ($item) {
                return Arr::get($item, 'class') !== self::class;
            })
            ->filter(function ($item) {
                return Arr::get($item, 'function') !== 'raid';
            })
            ->first();

        if (blank($origin)) {
            return;
        }

        $this->addContext('origin', [
            'class' => Arr::get($origin, 'class'),
            'function' => Arr::get($origin, 'function'),
        ]);
    }

    private function prepareContext(array $context): void
    {
        $this->addContext('origin.line', $this->getLineFromBacktrace());

        foreach ($context as $key => $value) {
            $this->addContext($key, $value);
        }
    }

    private function unsetContext(array $context): void
    {
        foreach ($context as $key => $value) {
            $this->removeContext($key);
        }
    }
}
