<?php

namespace TicTacToe\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Model\Board;
use TicTacToe\Domain\Model\Position;

class BoardTest extends TestCase
{
    /**
     * @test
     * @expectedException TicTacToe\Domain\Exception\InvalidBoardSize
     * @expectedExceptionMessage The board size is invalid
     *
     * @dataProvider             invalidBoard
     *
     * @param $board
     */
    public function given_an_invalid_board_then_should_throw_an_exception($board)
    {
        new Board($board);
    }

    public function invalidBoard()
    {
        return [
            'empty' => [
                [],
            ],
            'one_rows' => [
                [
                    ['', '', '']
                ],
            ],
            'two_rows' => [
                [
                    ['', '', ''],
                    ['', '', ''],
                ],
            ],
            'four_rows' => [
                [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ],
            ],
        ];
    }

    /**
     * @test
     * @expectedException TicTacToe\Domain\Exception\InvalidRowSize
     * @expectedExceptionMessage The row size is invalid
     *
     * @dataProvider             invalidRow
     *
     * @param $board
     */
    public function given_a_boar_with_more_colums_then_should_throw_an_exception($board)
    {
        new Board($board);
    }

    public function invalidRow()
    {
        return [
            'one_column' => [
                [
                    [''],
                    [''],
                    [''],
                ],
            ],
            'two_columns' => [
                [
                    ['', ''],
                    ['', ''],
                    ['', ''],
                ],
            ],
            'four_columns' => [
                [
                    ['', '', '', ''],
                    ['', '', '', ''],
                    ['', '', '', ''],
                ],
            ],
        ];
    }

    /**
     * @test
     * @expectedException TicTacToe\Domain\Exception\PositionIsAlreadyTaken
     */
    public function given_a_non_empty_position_when_try_to_mark_then_has_to_throw_an_exception()
    {
        $state = [
            ['', '', ''],
            ['', 'X', ''],
            ['', '', ''],
        ];

        $board = new Board($state);
        $board->markPosition(new Position(1, 1), 'O');
    }

}
