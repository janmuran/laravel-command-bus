<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Example\Command;

use Janmuran\LaravelCommandBus\Model\Command;

final class ChangePersonAge implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly int $age,
    ) {
    }
}
