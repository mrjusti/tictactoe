<?php

namespace App\Bus;

use App\Bus\Locator\LocatorInterface;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Plugins\LockingMiddleware;
use ReflectionClass;
use InvalidArgumentException;

class Bus implements CommandBusInterface
{
    private $bus;

    private $methodNameInflector;

    private $commandNameExtractor;

    private $handlerLocator;

    public function __construct(
        MethodNameInflector $MethodNameInflector,
        CommandNameExtractor $CommandNameExtractor,
        LocatorInterface $HandlerLocator
    ) {
        $this->methodNameInflector  = $MethodNameInflector;
        $this->commandNameExtractor = $CommandNameExtractor;
        $this->handlerLocator       = $HandlerLocator;
    }

    /**
     * Dispatch a command
     *
     * @param  object $command    Command to be dispatched
     * @param  array  $input      Array of input to map to the command
     * @param  array  $middleware Array of middleware class name to add to the stack, they are resolved from the laravel container
     * @return mixed
     */
    public function dispatch($command, array $input = [], array $middleware = [])
    {
        return $this->handleTheCommand($command, $input, $middleware);
    }

    /**
     * Add the Command Handler
     *
     * @param  string $command Class name of the command
     * @param  string $handler Class name of the handler to be resolved from the Laravel Container
     * @return mixed
     */
    public function addHandler($command, $handler)
    {
        $this->handlerLocator->addHandler($handler, $command);
    }

    /**
     * Handle the command
     *
     * @param  $command
     * @param  $input
     * @param  $middleware
     * @return mixed
     */
    protected function handleTheCommand($command, $input, array $middleware)
    {
        $this->bus = new CommandBus(
            array_merge(
                [new LockingMiddleware()],
                $this->resolveMiddleware($middleware),
                [new CommandHandlerMiddleware($this->commandNameExtractor, $this->handlerLocator, $this->methodNameInflector)]
            )
        );

        return $this->bus->handle($this->mapInputToCommand($command, $input));
    }

    /**
     * Resolve the middleware stack from the laravel container
     *
     * @param  $middleware
     * @return array
     */
    protected function resolveMiddleware(array $middleware)
    {
        $m = [];
        foreach ($middleware as $class) {
            $m[] = app($class);
        }

        return $m;
    }

    /**
     * Map the input to the command
     *
     * @param  $command
     * @param  $input
     * @return object
     */
    protected function mapInputToCommand($command, $input)
    {
        if (is_object($command)) {
            return $command;
        }
        $dependencies = [];
        $class = new ReflectionClass($command);
        foreach ($class->getConstructor()->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (array_key_exists($name, $input)) {
                $dependencies[] = $input[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new InvalidArgumentException("Unable to map input to command: {$name}");
            }
        }

        return $class->newInstanceArgs($dependencies);
    }
}
