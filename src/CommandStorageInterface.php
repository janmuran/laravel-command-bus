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
     * @param class-string $handler
     */
    public function addCommand(string $command, string $handler): void;

    /**
     * @return class-string
     */
    public function getCommandClass(string $commandName): string;

    /**
     * @return array<string, class-string>
     */
    public function getCommands(): array;
}
