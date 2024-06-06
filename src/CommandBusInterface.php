<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

use Janmuran\LaravelCommandBus\Model\Command;
use Janmuran\LaravelCommandBus\Model\CommandHandler;

interface CommandBusInterface
{
    public function dispatch(Command $command): mixed;

    /**
     * @param array<class-string<Command>,class-string<CommandHandler>> $map
     * @return void
     */
    public function map(array $map): void;
}
