<?php

namespace TicTacToe\Tests\Stub;

use TicTacToe\Domain\Model\PerfectMove\PerfectMoveStrategy;

class PerfectMoveStub
{
    public static function get() : PerfectMoveStrategy
    {
        return new PerfectMoveStrategy();
    }
}
