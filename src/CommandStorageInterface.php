<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

interface CommandStorageInterface
{
    /**
     * @param array<class-string, class-string> $commands
     */
    public function addCommands(array $commands): void;

    /**
     * @param class-string $command
     */
    public function addCommand(string $commandName, string $command): void;

    /**
     * @return class-string
     */
    public function getCommandClass(string $commandName): string;
}
