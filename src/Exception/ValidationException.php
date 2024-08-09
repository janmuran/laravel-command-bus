<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus\Exception;

use Exception;

class ValidationException extends Exception
{
    /**
     * @var array<mixed>
     */
    private array $errors;

    /**
     * @param array<mixed> $errors
     */
    public function __construct(array $errors, int $code = 400)
    {
        $this->errors = $errors;
        parent::__construct('Validation error', $code);
    }

    /**
     * @param array<mixed> $errors
     */
    public static function create(array $errors, int $code = 400): self
    {
        return new self($errors, $code);
    }

    /**
     * @return array<mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
