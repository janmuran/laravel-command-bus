<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

use Illuminate\Http\Request;
use Janmuran\LaravelCommandBus\Model\Command;
use JMS\Serializer\ArrayTransformerInterface;

final class CommandBuilder implements CommandBuilderInterface
{
    public function __construct(
        private readonly ArrayTransformerInterface $arrayTransformer,
        private readonly CommandStorageInterface $commandStorage,
    ) {
    }

    public function createCommand(Request $request): Command
    {
        $data = $request->all();
        $command = $data['command'];

        /** @var class-string $class */
        $class = $this->commandStorage->getCommandClass($command);

        /** @var Command $command */
        $command = $this->arrayTransformer->fromArray($data['params'], $class);

        return $command;
    }
}
