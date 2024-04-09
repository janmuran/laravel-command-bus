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
     * @param array<class-string, class-string> $commands
     */
    public function addCommands(array $commands): void
    {
        foreach ($commands as $command => $handler) {
            $this->addCommand($this->getClassShortName($command), $command);
        }
    }

    /**
     * @param class-string $command
     */
    public function addCommand(string $commandName, string $command): void
    {
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
}
