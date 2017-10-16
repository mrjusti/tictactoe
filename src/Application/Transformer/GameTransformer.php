<?php

namespace TicTacToe\Application\Transformer;

use TicTacToe\Domain\Model\GameState;

interface GameTransformer
{
    public function write(GameState $game) : GameTransformer;

    public function read();
}
