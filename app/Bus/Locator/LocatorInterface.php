<?php

namespace App\Bus\Locator;

use League\Tactician\Handler\Locator\HandlerLocator;

interface LocatorInterface extends HandlerLocator
{
    public function addHandler($handler, $commandClassName);

    public function addHandlers(array $commandClassToHandlerMap);
}
