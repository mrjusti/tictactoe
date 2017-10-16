<?php

namespace TicTacToe\Domain\Service;

use TicTacToe\Domain\Model\BotPlayer;
use TicTacToe\Domain\Model\GameState;

class NextMoveMaker
{
    public function move(GameState $state, BotPlayer $botPlayer): GameState
    {
        if ($state->isOver()) {
            return $state;
        }

        return $botPlayer->move($state);
    }
}
