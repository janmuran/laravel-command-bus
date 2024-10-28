<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Exception;

use Exception;

class HttpException extends Exception
{
    public function __construct(string $error, int $code = 400)
    {
        if ($code < 400 || $code > 599) {
            throw new Exception('Invalid HTTP code. Allowed range is 400-599.');
        }

        parent::__construct($error, $code);
    }

    public static function create(string $error, int $code = 400): self
    {
        return new self($error, $code);
    }
}
