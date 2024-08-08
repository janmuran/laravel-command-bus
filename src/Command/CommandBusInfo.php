<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Command;

use Illuminate\Console\Command;
use Janmuran\LaravelCommandBus\CommandBusInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

final class CommandBusInfo extends Command
{
    protected $signature = 'command-bus:detail {command}';

    protected $description = 'Show available command info';

    public function __construct(
        private readonly CommandBusInterface $bus,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        /** @var string $commandName */
        $commandName = $this->argument('command');
        $handler = $this->bus->getCommandHandler($commandName);
        if ($handler === null) {
            $this->output->error('Command not found');

            return Command::FAILURE;
        }

        $this->showCommandInfo($handler);

        return Command::SUCCESS;
    }

    /**
     * @param class-string $handler
     */
    private function showCommandInfo(string $handler): void
    {
        $object = new ReflectionClass($handler);
        $method = $object->getMethod('handle');
        if (!$method instanceof ReflectionMethod) {
            $this->error('Method handle not found');

            return;
        }

        /** @var ReflectionParameter|null $parameter */
        $parameter = $method->getParameters()[0] ?? null;
        if ($parameter === null) {
            $this->error('Method handle not found');

            return;
        }

        $object = new ReflectionClass($parameter->getType());
        dd($object);
    }
}
