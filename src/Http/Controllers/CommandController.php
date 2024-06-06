<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Janmuran\LaravelCommandBus\CommandBuilderInterface;
use Janmuran\LaravelCommandBus\CommandBus;
use Janmuran\LaravelCommandBus\Exception\ValidationException;
use Janmuran\LaravelCommandBus\Response\ResponseStorageInterface;
use Throwable;

class CommandController
{
    public function __construct(
        private readonly CommandBus $bus,
        private readonly ResponseStorageInterface $responseStorage,
        private readonly CommandBuilderInterface $commandBuilder,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $command = $this->commandBuilder->createCommand($request);
            $this->bus->dispatch($command);
        } catch (ValidationException $exception) {
            return new JsonResponse($exception->getErrors(), Response::HTTP_BAD_REQUEST);
        } catch (Throwable $exception) {
            return $this->createErrorJsonResponseFromException($exception);
        }

        $response = $this->responseStorage->getResponse();
        if (is_array($response)) {
            $this->createSuccessJsonResponse($response);
        }


        return $this->createSuccessJsonResponse();
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
