<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

use Janmuran\LaravelCommandBus\Model\Command;
use Illuminate\Bus\Dispatcher;

final class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly Dispatcher $bus,
        private CommandStorage $commandStorage,
    ) {
    }

    public function dispatch(Command $command): mixed
    {
        return $this->bus->dispatch($command);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
        $this->commandStorage->addCommands($map);
    }
}
