## Laravel command bus

Simple command bus for laravel. Use jms serializer for build command.

### Install

`composer require janmuran/laravel-command-bus`

### Publish 

`php artisan vendor:publish --provider="Janmuran\LaravelCommandBus\CommandBusServiceProvider"`

### Register command

Add this lines to AppServiceProvider.php

        $commandBus = resolve(CommandBus::class);

        $commandBus->map([
            CommandExample::class => CommandExampleHandler::class,
        ]);


### Validation data

request can be validated in Command handler.  
If you require all errors in response array use ValidationException 


        $validation = \Illuminate\Support\Facades\Validator::make(
                $data,
                [
                    'age' => 'require|min:20',
                ],
        ); 

        if ($validation->fails()) {
            throw ValidationException::create($validation->errors()->toArray());
        }