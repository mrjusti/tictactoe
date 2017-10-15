<?php

namespace TicTacToe\Domain\Service;

use TicTacToe\Domain\Model\BotPlayer;
use TicTacToe\Domain\Model\State;

class NextMoveMaker
{
    public function move(State $state, BotPlayer $botPlayer): State
    {
        if ($state->isOver()) {
            return $state;
        }

        return $botPlayer->move($state);
    }
}
