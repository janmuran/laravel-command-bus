<?php

namespace Janmuran\LaravelCommandBus;

use Illuminate\Support\Facades\Route;
use Janmuran\LaravelCommandBus\Http\Controllers\CommandController;
use Janmuran\LaravelCommandBus\Response\ResponseStorage;
use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;
use Illuminate\Support\ServiceProvider;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerServices();

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class); // @phpstan-ignore-line

        $commandBus->map([]);
    }

    public function boot(): void
    {
        $this->registerControllers();
    }

    private function registerControllers(): void
    {
        // @phpstan-ignore-next-line
        Route::post("command/run", '\\' . CommandController::class)
            ->name('commmand-bus-run-command'); // @phpstan-ignore-line
    }

    private function registerServices(): void
    {
        $this->app->singleton(Serializer::class, function (): Serializer {
            return SerializerBuilder::create()
                ->build();
        });

        $this->app->bind(SerializerInterface::class, Serializer::class);
        $this->app->bind(ArrayTransformerInterface::class, Serializer::class);

        $this->app->singleton(
            abstract: CommandBuilderInterface::class,
            concrete: CommandBuilder::class,
        );

        $this->app->singleton(
            abstract: CommandBusInterface::class,
            concrete: CommandBus::class,
        );

        $this->app->singleton(
            abstract: CommandStorageInterface::class,
            concrete: CommandStorage::class,
        );

        $this->app->singleton(
            abstract: ResponseStorageInterface::class,
            concrete: ResponseStorage::class,
        );
    }
}
