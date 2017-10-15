<?php

namespace App\Providers;

use App\Bus\CommandBusInterface;
use App\Bus\Locator\LocatorInterface;
use Illuminate\Support\ServiceProvider;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

class TacticianServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfig();
        $this->app->bind(LocatorInterface::class, config('tactician.locator'));
        $this->app->bind(MethodNameInflector::class, config('tactician.inflector'));
        $this->app->bind(CommandNameExtractor::class, config('tactician.extractor'));
        $this->app->singleton(CommandBusInterface::class, config('tactician.bus'));
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/tactician.php',
            'tactician'
        );
    }
}
