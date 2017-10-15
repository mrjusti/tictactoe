<?php

namespace TicTacToe\Tests\Stub;

use TicTacToe\Domain\Model\Board;

class BoardStub
{
    public static function get(array $state = null) : Board
    {
        return new Board($state ?? [['', '', ''], ['', '', ''], ['', '', '']]);
    }
}
