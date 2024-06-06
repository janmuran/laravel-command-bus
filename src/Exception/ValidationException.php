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
    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation error');
    }

    /**
     * @param array<mixed> $errors
     */
    public static function create(array $errors): self
    {
        return new self($errors);
    }

    /**
     * @return array<mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
