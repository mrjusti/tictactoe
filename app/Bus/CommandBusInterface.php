<?php

namespace App\Bus;

interface CommandBusInterface
{
    public function dispatch($command, array $input = [], array $middleware = []);
    public function addHandler($command, $handler);
}
