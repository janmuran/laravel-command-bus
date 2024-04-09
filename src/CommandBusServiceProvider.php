<?php

namespace Janmuran\LaravelCommandBus;

use Illuminate\Support\Facades\Route;
use Janmuran\LaravelCommandBus\Http\Controllers\Command\CommandController;
use Janmuran\LaravelCommandBus\Response\ResponseStorage;
use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->map([
        ]);
    }

    public function boot()
    {
        $this->registerServices();
        $this->registerControllers();
    }

    private function registerControllers(): void
    {
        Route::post("command/run", '\\' . CommandController::class)
            ->name('commmand-bus-run-command');
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
