## Laravel command bus

Simple command bus for laravel. Use jms serializer for build command.

### Install

`composer require janmuran/laravel-command-bus`

## Example

### Create Command
Command is object that implement Janmuran\LaravelCommandBus\Model\Command interface.

    <?php

    declare(strict_types=1);

    namespace Janmuran\LaravelCommandBus\Example\Command;

    use Janmuran\LaravelCommandBus\Model\Command;

    final class ChangePersonAge implements Command
    {
        public function __construct(
            public readonly string $name,
            public readonly int $age,
        ) {
        }
    }

### Create Command Handler
 
    <?php

    declare(strict_types=1);

    namespace Janmuran\LaravelCommandBus\Example\Handler;

    use Janmuran\LaravelCommandBus\Example\Command\ChangePersonAge;
    use Janmuran\LaravelCommandBus\Model\CommandHandler;
    use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;

    final class ChangePersonAgeHandler implements CommandHandler
    {
        public const NUMBER = 10;

        public function __construct(
            private ResponseStorageInterface $responseStorage,
        ) {
        }

        public function handle(ChangePersonAge $command): void
        {
            $newAge = $command->age + self::NUMBER;

            $this->responseStorage->setResponse([
                'newAge' => $newAge,
                'commad' => $command,
            ]);
        }
    }

### Register command

Add this lines to AppServiceProvider.php

        $commandBus = resolve(CommandBus::class);

        $commandBus->map([
            CommandExample::class => CommandExampleHandler::class,
            ChangePersonAge::class => ChangePersonAgeHandler::class,
        ]);

### Usage

Endpoint for command request: `/command/run`

example json request:

    {
        "command": "ChangePersonAge",
        "params": {
            "name": "Test Name",
            "age": 24
        }
    }

#### POST request is automaticaly build to command object and handled by Command handler.


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