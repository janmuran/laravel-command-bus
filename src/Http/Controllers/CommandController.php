<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Http\Controllers\Command;

use Janmuran\LaravelCommandBus\CommandBusInterface;
use Janmuran\LaravelCommandBus\CommandStorageInterface;
use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
use Throwable;

class CommandController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CommandBusInterface $bus,
        private readonly CommandStorageInterface $commandStorage,
        private readonly ResponseStorageInterface $responseStorage,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            /** @var class-string $class */
            $class = $this->commandStorage->getCommandClass($data['command']);
            $command = $this->serializer->deserialize(json_encode($data['params']), $class, 'json');
            $this->bus->dispatch($command);
        } catch (Throwable $exception) {
            return $this->createErrorJsonResponseFromException($exception);
        }

        return $this->createSuccessJsonResponse($this->responseStorage->getResponse());
    }

    private function createSuccessJsonResponse(array $params = []): JsonResponse
    {
        $data = ['status' => 'ok'];
        if (count($params) > 0) {
            $data['data'] = $params;
        }

        return new JsonResponse($data);
    }

    private function createErrorJsonResponseFromException(Throwable $exception): JsonResponse
    {
        $data = ['status' => 'error'];
        $data['error'] = $exception->getMessage();

        return new JsonResponse($data, Response::HTTP_BAD_REQUEST);
    }
}
