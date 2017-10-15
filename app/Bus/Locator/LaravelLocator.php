<?php

namespace App\Bus\Locator;

use League\Tactician\Exception\MissingHandlerException;

class LaravelLocator implements LocatorInterface
{
    protected $handlers;

    public function addHandler($handler, $commandClassName)
    {
        $handlerInstance = $handler;
        $this->handlers[$commandClassName] = $handlerInstance;
    }

    public function addHandlers(array $commandClassToHandlerMap)
    {
        foreach ($commandClassToHandlerMap as $commandClass => $handler) {
            $this->addHandler($handler, $commandClass);
        }
    }

    public function getHandlerForCommand($commandName)
    {
        if (!isset($this->handlers[$commandName])) {
            throw MissingHandlerException::forCommand($commandName);
        }

        return app($this->handlers[$commandName]);
    }
}
