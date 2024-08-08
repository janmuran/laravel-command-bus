<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Model;

interface FormCommand extends Command
{
    /**
     * @return class-string|null
     */
    public static function getRequestType(): string|null;
}
