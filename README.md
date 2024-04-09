## Laravel command bus

Simple command bus for laravel. Use jms serializer for build command.

### Install

`composer require janmuran/laravel-command-bus`


### Register command

        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->map([
        ]);