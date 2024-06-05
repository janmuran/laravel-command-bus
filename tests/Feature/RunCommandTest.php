<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Tests\Feature;

use Janmuran\LaravelCommandBus\CommandBus;
use Janmuran\LaravelCommandBus\CommandBusInterface;
use Janmuran\LaravelCommandBus\CommandStorage;
use Janmuran\LaravelCommandBus\CommandStorageInterface;
use Janmuran\LaravelCommandBus\Example\Command\ChangePersonAge;
use Janmuran\LaravelCommandBus\Example\Handler\ChangePersonAgeHandler;
use Janmuran\LaravelCommandBus\Response\ResponseStorage;
use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;
use Orchestra\Testbench\TestCase;

final class RunCommandTest extends TestCase
{
    private CommandBusInterface $bus;
    private ResponseStorageInterface $responseStorage;
    private string $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(CommandBusInterface::class, CommandBus::class);
        $this->app->singleton(CommandStorageInterface::class, CommandStorage::class);
        $this->app->singleton(ResponseStorageInterface::class, ResponseStorage::class);
        $this->bus = resolve(CommandBusInterface::class);
        $this->responseStorage = resolve(ResponseStorageInterface::class);
        $this->data = file_get_contents(__DIR__ . '/data/person.json');
        $this->bus->map([
            ChangePersonAge::class => ChangePersonAgeHandler::class,
        ]);
    }

    public function testRunCommand(): void
    {
        $command = new ChangePersonAge('Hello', 20);
        $this->bus->dispatch($command);

        $response = $this->responseStorage->getResponse();

        $this->assertTrue(is_array($response));
        $newAge = $response['newAge'] ?? null;
        $this->assertEquals($newAge, $command->age + ChangePersonAgeHandler::NUMBER);
        $model = $response['commad'] ?? null;
        $this->assertInstanceOf(ChangePersonAge::class, $model);
    }
}
