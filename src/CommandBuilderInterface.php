<?php

declare(strict_types=1);

namespace Janmuran\LaravelCommandBus;

use Illuminate\Http\Request;
use Janmuran\LaravelCommandBus\Model\Command;

interface CommandBuilderInterface
{
    public function createCommand(Request $request): Command;
}
