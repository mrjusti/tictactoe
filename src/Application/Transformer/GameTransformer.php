<?php

namespace TicTacToe\Application\Transformer;

use TicTacToe\Domain\Model\State;

interface GameTransformer
{
    public function write(State $game) : GameTransformer;

    public function read();
}
