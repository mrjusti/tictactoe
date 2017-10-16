<?php

namespace TicTacToe\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Model\Game;
use TicTacToe\Domain\Model\State;
use TicTacToe\Tests\Stub\PerfectMoveStub;

class PerfectMoveTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_full_board_minus_one_then_must_return_the_last_position()
    {
        $board = [
            ['X', 'O', 'X'],
            ['O', 'X', 'O'],
            ['O', 'X', ''],
        ];
        $move = PerfectMoveStub::get();
        $position = $move->makeMove($board, 'X');

        $this->assertEquals([2, 2, 'X'], $position);
    }

    /**
     * @test
     */
    public function given_two_left_positions_then_must_return_the_one_to_win()
    {
        $board = [
            ['O', 'O', 'X'],
            ['X', 'O', ''],
            ['O', 'X', ''],
        ];
        $move = PerfectMoveStub::get();
        $position = $move->makeMove($board, State::UNIT_BOT);

        $this->assertEquals([2, 2, State::UNIT_BOT], $position);
    }

    /**
     * @test
     */
    public function given_two_left_positions_when_can_win_the_game_then_must_return_the_one_to_draw()
    {
        $board = [
            ['X', 'X', 'O'],
            ['O', 'X', ''],
            ['X', 'O', ''],
        ];
        $move = PerfectMoveStub::get();
        $position = $move->makeMove($board, State::UNIT_BOT);

        $this->assertEquals([2, 2, State::UNIT_BOT], $position);
    }

    /**
     * @test
     * @dataProvider possibleWinnerGames
     *
     * @param $board
     * @param $expected
     */
    public function given_a_winner_position_free_then_must_play_for_win($board, $expected)
    {
        $move = PerfectMoveStub::get();
        $position = $move->makeMove($board, State::UNIT_BOT);

        $this->assertEquals($expected, $position);
    }

    public function possibleWinnerGames()
    {
        return [
            [
                [
                    ['', 'O', 'X'],
                    ['X', '', ''],
                    ['', '', 'O'],
                ],
                [1, 1, State::UNIT_BOT]
            ],
            [
                [
                    ['O', '', ''],
                    ['X', '', 'X'],
                    ['X', 'O', ''],
                ],
                [1, 1, State::UNIT_BOT]
            ],
            [
                [
                    ['O', 'O', ''],
                    ['X', 'X', 'O'],
                    ['X', 'O', ''],
                ],
                [2, 0, State::UNIT_BOT]
            ],
            [
                [
                    ['O', 'O', 'X'],
                    ['X', 'X', 'O'],
                    ['O', 'X', ''],
                ],
                [2, 2, State::UNIT_BOT]
            ],
            [
                [
                    ['X', '', 'O'],
                    ['O', '', 'O'],
                    ['', 'X', 'X'],
                ],
                [1, 1, State::UNIT_BOT]
            ],
            [
                [
                    ['X', '', 'O'],
                    ['O', '', ''],
                    ['O', 'X', 'X'],
                ],
                [1, 1, State::UNIT_BOT]
            ],
            [
                [
                    ['X', 'X', 'O'],
                    ['', 'O', ''],
                    ['', '', 'X'],
                ],
                [0, 2, State::UNIT_BOT]
            ],
        ];
    }

    /**
     * @test
     * @dataProvider possibleLoseGames
     *
     * @param $board
     * @param $expected
     */
    public function given_a_loser_position_free_then_must_play_to_avoid_loose($board, $expected)
    {
        $move = PerfectMoveStub::get();
        $position = $move->makeMove($board, State::UNIT_BOT);

        $this->assertEquals($expected, $position);
    }

    public function possibleLoseGames()
    {
        return [
            [
                [
                    ['X', 'O', 'O'],
                    ['', 'X', 'X'],
                    ['', 'O', 'X'],
                ],
                [0, 1, State::UNIT_BOT]
            ],
            [
                [
                    ['O', 'X', 'O'],
                    ['', 'X', 'X'],
                    ['X', 'O', ''],
                ],
                [0, 1, State::UNIT_BOT]
            ],
            [
                [
                    ['O', '', 'X'],
                    ['X', '', ''],
                    ['X', 'O', 'O'],
                ],
                [1, 1, State::UNIT_BOT]
            ],
            [
                [
                    ['O', 'X', 'X'],
                    ['X', '', ''],
                    ['X', 'O', 'O'],
                ],
                [1, 1, State::UNIT_BOT]
            ],
        ];
    }
}
