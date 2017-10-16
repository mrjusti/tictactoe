<?php

namespace TicTacToe\Tests\Stub;

use TicTacToe\Domain\Model\GameState;

class GameStateStub
{
    public static function get(array $state = null) : GameState
    {
        return new GameState(BoardStub::get($state ?? [['', '', ''], ['', '', ''], ['', '', '']]));
    }
}
