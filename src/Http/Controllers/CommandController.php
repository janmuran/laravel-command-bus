<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Http\Controllers;

use Janmuran\LaravelCommandBus\CommandBus;
use Janmuran\LaravelCommandBus\CommandStorageInterface;
use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
use RuntimeException;
use Throwable;

class CommandController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CommandBus $bus,
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
            $json = json_encode($data['params']);
            if ($json === false) {
                throw new RuntimeException('Unable encode command data');
            }

            $command = $this->serializer->deserialize($json, $class, 'json');
            $this->bus->dispatch($command);
        } catch (Throwable $exception) {
            return $this->createErrorJsonResponseFromException($exception);
        }

        return $this->createSuccessJsonResponse($this->responseStorage->getResponse());
    }

    /**
     * @param array<mixed> $params
     */
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
