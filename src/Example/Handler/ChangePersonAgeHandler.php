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
