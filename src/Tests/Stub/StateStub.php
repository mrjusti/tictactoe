<?php

namespace TicTacToe\Tests\Stub;

use TicTacToe\Domain\Model\State;

class StateStub
{
    public static function get(array $state = null) : State
    {
        return new State(BoardStub::get($state ?? [['', '', ''], ['', '', ''], ['', '', '']]));
    }
}
