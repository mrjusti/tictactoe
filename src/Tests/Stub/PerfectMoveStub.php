<?php

namespace TicTacToe\Tests\Stub;

use TicTacToe\Domain\Model\Move\PerfectMove;

class PerfectMoveStub
{
    public static function get() : PerfectMove
    {
        return new PerfectMove();
    }
}
