<?php

namespace TicTacToe\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Model\State;
use TicTacToe\Tests\Stub\BoardStub;
use TicTacToe\Tests\Stub\PerfectMovePlayerStub;
use TicTacToe\Tests\Stub\StateStub;

class StateTest extends TestCase
{
    /**
     * @test
     */
    public function given_all_field_taken_when_check_if_game_is_over_then_must_return_true()
    {
        $board     = [
            ['X', 'O', 'X'],
            ['X', 'O', 'X'],
            ['X', 'O', 'X'],
        ];
        $gameState = StateStub::get($board);
        $this->assertTrue($gameState->isOver());
    }

    /**
     * @test
     * @dataProvider fieldsInARow
     *
     * @param $board
     */
    public function given_all_field_in_a_row_taken_by_a_player_when_check_if_game_is_over_then_must_return_true($board)
    {
        $gameState = StateStub::get($board);
        $this->assertTrue($gameState->isOver());
    }

    public function fieldsInARow()
    {
        return [
            'first_row' => [
                [
                    ['X', 'X', 'X'],
                    ['O', 'O', 'X'],
                    ['', 'O', 'O'],
                ]
            ],
            'second_row' => [
                [
                    ['O', '0', 'X'],
                    ['X', 'X', 'X'],
                    ['X', '', 'O'],
                ],
            ],
            'third_row' => [
                [
                    ['O', 'O', ''],
                    ['X', 'O', 'O'],
                    ['X', 'X', 'X'],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider fieldsInAColumn
     *
     * @param $board
     */
    public function given_all_field_in_a_column_taken_by_a_player_when_check_if_game_is_over_then_must_return_true($board)
    {
        $gameState = StateStub::get($board);
        $this->assertTrue($gameState->isOver());
    }

    public function fieldsInAColumn()
    {
        return [
            'first_row' => [
                [
                    ['X', 'X', 'O'],
                    ['X', '', 'X'],
                    ['X', 'O', 'O'],
                ],
            ],
            'second_row' => [
                [
                    ['O', 'X', 'X'],
                    ['X', 'X', 'X'],
                    ['', 'X', 'O'],
                ],
            ],
            'third_row' => [
                [
                    ['O', 'X', 'O'],
                    ['X', 'O', 'O'],
                    ['X', '', 'O'],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider fieldsInADiagonal
     *
     * @param $board
     */
    public function given_all_field_taken_in_a_diagonal_by_a_player_when_check_if_game_is_over_then_must_return_true($board)
    {
        $gameState = StateStub::get($board);
        $this->assertTrue($gameState->isOver());
    }

    public function fieldsInADiagonal()
    {
        return [
            'diagonal' => [
                [
                    ['X', 'X', 'O'],
                    ['O', 'X', 'X'],
                    ['', 'O', 'X'],
                ],
            ],
            'inverse_diagonal' => [
                [
                    ['O', 'X', 'X'],
                    ['X', 'X', 'O'],
                    ['X', 'O', ''],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider emptyFields
     *
     * @param $board
     */
    public function given_empty_fields_and_no_winner_when_check_if_game_is_over_then_must_return_false($board)
    {
        $gameState = StateStub::get($board);
        $this->assertFalse($gameState->isOver());
    }

    public function emptyFields()
    {
        return [
            [
                [
                    ['X', 'X', 'O'],
                    ['O', '', 'X'],
                    ['', 'O', 'X'],
                ],
            ],
            [
                [
                    ['O', 'X', 'X'],
                    ['X', '', 'O'],
                    ['X', 'O', ''],
                ],
            ],
            [
                [
                    ['', '', ''],
                    ['X', 'X', 'O'],
                    ['X', 'O', ''],
                ],
            ],
            [
                [
                    ['', 'X', 'O'],
                    ['', 'X', 'O'],
                    ['', 'O', ''],
                ],
            ],
            [
                [
                    ['', 'X', 'O'],
                    ['X', '', 'O'],
                    ['', 'O', ''],
                ],
            ],
            [
                [
                    ['O', 'X', ''],
                    ['X', '', 'O'],
                    ['', 'O', ''],
                ],
            ],
            [
                [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider humanWin
     *
     * @param $board
     */
    public function given_a_game_that_the_human_player_win_when_get_state_then_must_return_human_win($board)
    {
        $gameState = StateStub::get($board);
        $this->assertSame(State::STATUS_WIN_HUMAN, $gameState->status());
    }

    public function humanWin()
    {
        return [
            'row' => [
                [
                    ['X', 'X', 'X'],
                    ['X', '', 'O'],
                    ['', 'X', 'O'],
                ],
            ],
            'column' => [
                [
                    ['X', '', 'X'],
                    ['X', '', 'O'],
                    ['X', 'X', 'O'],
                ],
            ],
            'diagonal' => [
                [
                    ['X', '', 'X'],
                    ['X', 'X', 'O'],
                    ['', 'X', 'X'],
                ],
            ],
            'inverse_diagonal' => [
                [
                    ['X', '', 'X'],
                    ['', 'X', 'O'],
                    ['X', 'X', ''],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider robotWin
     *
     * @param $board
     */
    public function given_a_game_where_the_robot_player_win_when_get_state_must_return_robot_win($board)
    {
        $gameState = StateStub::get($board);
        $this->assertSame(State::STATUS_WIN_BOT, $gameState->status());
    }

    public function robotWin()
    {
        return [
            'row' => [
                [
                    ['O', 'O', 'O'],
                    ['X', '', 'X'],
                    ['', 'X', 'O'],
                ],
            ],
            'column' => [
                [
                    ['O', '', 'X'],
                    ['O', '', 'O'],
                    ['O', 'X', 'O'],
                ],
            ],
            'diagonal' => [
                [
                    ['O', '', 'X'],
                    ['X', 'O', 'O'],
                    ['', 'X', 'O'],
                ],
            ],
            'inverse_diagonal' => [
                [
                    ['X', '', 'O'],
                    ['', 'O', 'O'],
                    ['O', 'X', ''],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider running
     *
     * @param $board
     */
    public function given_an_incomplete_board_when_get_state_then_must_return_running($board)
    {
        $gameState = StateStub::get($board);
        $this->assertSame(State::STATUS_RUNNING, $gameState->status());
    }

    public function running()
    {
        return [
            'empty' => [
                [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ],
            ],
            'without_winner' => [
                [
                    ['X', '', ''],
                    ['', 'O', 'O'],
                    ['', '', 'X'],
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function given_a_complete_board_when_get_state_then_must_return_draw()
    {
        $board     = [
            ['X', 'X', 'O'],
            ['O', 'O', 'X'],
            ['X', 'O', 'X'],
        ];
        $gameState = StateStub::get($board);
        $this->assertSame(State::STATUS_DRAW, $gameState->status());
    }
}
