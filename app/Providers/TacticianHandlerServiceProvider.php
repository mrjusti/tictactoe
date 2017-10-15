<?php

namespace App\Providers;

use App\Bus\CommandBusInterface;
use Illuminate\Support\ServiceProvider;
use TicTacToe\Application\Service\MakeMoveQuery;
use TicTacToe\Application\Service\MakeMoveQueryHandler;

class TacticianHandlerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $bus = $this->app->get(CommandBusInterface::class);

        $bus->addHandler(MakeMoveQuery::class, MakeMoveQueryHandler::class);
    }
}
