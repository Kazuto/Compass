<?php

namespace App\Actions;

use App\Support\Logging\Raid;
use DeepCopy\Exception\PropertyException;

class Action
{
    private Raid $raid;

    /**
     * @throws PropertyException
     */
    public function __construct()
    {
        $this->validateChildClass();

        $this->raid = Raid::new();
        $this->raid
            ->addContext('action', get_called_class())
            ->addContext('actor', auth()->user() ?? null)
            ->debug(static::$description);
    }

    /**
     * @throws PropertyException
     */
    private function validateChildClass(): void
    {
        $this->ensureStaticPropertyExists('description');
    }

    /**
     * @throws PropertyException
     */
    private function ensureStaticPropertyExists(string $property): void
    {
        if (! isset(static::$$property)) {
            throw new PropertyException(sprintf('Child class %s failed to define static %s property', get_called_class(), $property));
        }
    }
}
