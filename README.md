## Laravel command bus

Simple command bus for laravel. Use jms serializer for build command.

### Install

`composer require janmuran/laravel-command-bus`

### Publish 

`php artisan vendor:publish --provider="Janmuran\LaravelCommandBus\CommandBusServiceProvider"`

### Register command

        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->map([
        ]);