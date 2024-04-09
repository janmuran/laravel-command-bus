<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Response;

final class ResponseStorage implements ResponseStorageInterface
{
    public function __construct(
        private mixed $response = [],
    ) {
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }

    public function setResponse(mixed $response): void
    {
        $this->response = $response;
    }
}
