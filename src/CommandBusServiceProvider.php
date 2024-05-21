<?php

namespace Janmuran\LaravelCommandBus;

use Illuminate\Support\Facades\Route;
use Janmuran\LaravelCommandBus\Http\Controllers\CommandController;
use Janmuran\LaravelCommandBus\Response\ResponseStorage;
use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerServices();

        $commandBus = resolve(CommandBusInterface::class); // @phpstan-ignore-line

        $commandBus->map([
        ]);
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
