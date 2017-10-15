<?php

use App\Bus\Locator\LaravelLocator;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

return [
    'locator' => LaravelLocator::class,
    'inflector' => HandleInflector::class,
    'extractor' => ClassNameExtractor::class,
    'bus' => \App\Bus\Bus::class,
];