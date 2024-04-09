<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Exception;

use RuntimeException;

final class CommandNotRegistered extends RuntimeException
{
    public static function create(string $commandName): self
    {
        return new self(sprintf('Command %s is not registered', $commandName));
    }
}