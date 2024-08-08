<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

use Illuminate\Bus\Dispatcher;

class CommandDispatcher extends Dispatcher
{
    /**
     * @return array<string, class-string>
     */
    public function getCommandHandlers(): array
    {
        return $this->handlers;
    }
}
