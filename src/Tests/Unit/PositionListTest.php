<?php

namespace TicTacToe\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Model\PositionList;

class PositionListTest extends TestCase
{
    /**
     * @test
     * @expectedException TicTacToe\Domain\Exception\PositionListOnlyCanHavePositionObjects
     * @dataProvider invalidPositions
     */
    public function given_not_position_then_must_throw_an_exception($positions)
    {
        new PositionList($positions);
    }

    public function invalidPositions()
    {
        return [
            [['asd']],
            [[new \stdClass()]],
        ];
    }
}
