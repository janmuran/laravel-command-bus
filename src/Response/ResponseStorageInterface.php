<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Response;

interface ResponseStorageInterface
{
    public function getResponse(): mixed;

    public function setResponse(mixed $response): void;
}
