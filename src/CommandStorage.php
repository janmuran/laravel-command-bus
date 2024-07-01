<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

use Janmuran\LaravelCommandBus\Exception\CommandNotRegistered;

final class CommandStorage implements CommandStorageInterface
{
    /**
     * @param array<string, class-string> $commands
     */
    public function __construct(
        private array $commands = [],
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @param array<class-string, class-string> $commands
     */
    public function addCommands(array $commands): void
    {
        foreach ($commands as $command => $handler) {
            $this->addCommand($command, $handler);
        }
    }

    /**
     * @param class-string $command
     * @param class-string $handler
     */
    public function addCommand(string $command, string $handler): void
    {
        $commandName = $this->getClassShortName($command);
        $this->commands[$commandName] = $command;
    }

    /**
     * @return class-string
     */
    public function getCommandClass(string $commandName): string
    {
        if (array_key_exists($commandName, $this->commands)) {
            return $this->commands[$commandName];
        }

        throw CommandNotRegistered::create($commandName);
    }

    /**
     * @param class-string $command
     */
    private function getClassShortName(string $command): string
    {
        $path = explode('\\', $command);

        return array_pop($path);
    }

    /**
     * @return array<string, class-string>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
