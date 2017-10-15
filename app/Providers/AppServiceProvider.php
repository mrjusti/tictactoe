<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TicTacToe\Application\Transformer\GameDTOTransformer;
use TicTacToe\Application\Transformer\GameTransformer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GameTransformer::class, GameDTOTransformer::class);
    }
}
