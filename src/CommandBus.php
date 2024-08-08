<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

use Janmuran\LaravelCommandBus\Model\Command;

final class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly CommandDispatcher $bus,
        private CommandStorageInterface $commandStorage,
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

    /**
     * @return class-string|null
     */
    public function getCommandHandler(string $command): ?string
    {
        /** @var class-string|null $handler */
        $handler = $this->bus->getCommandHandler($command);

        return $handler;
    }
}
