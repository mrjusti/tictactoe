<?php

namespace TicTacToe\Tests\Behaviour;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\MakeMoveQuery;
use TicTacToe\Application\Service\MakeMoveQueryHandler;
use TicTacToe\Application\Transformer\GameDTOTransformer;
use TicTacToe\Domain\Service\NextMoveMaker;

class MakeMoveTest extends TestCase
{
    /**
     * @test
     */
    public function given_an_already_finish_game_when_try_next_move_then_must_return_the_original_game_state()
    {
        // arrange
        $board = [
            ['X', 'X', 'X'],
            ['O', 'O', ''],
            ['', '', ''],
        ];

        // act
        $query = new MakeMoveQuery($board, 'X');
        $response = (new MakeMoveQueryHandler(new NextMoveMaker(), new GameDTOTransformer()))->handle($query);

        // assert
        $this->assertEquals($board, $response);
    }

    /**
     * @test
     * @dataProvider perfectMoves
     */
    public function given_a_perfect_game_started_by_human_when_try_next_play_then_must_return_perfect_moves($board, $expected)
    {
        // act
        $query = new MakeMoveQuery($board, 'X');
        $response = (new MakeMoveQueryHandler(new NextMoveMaker(), new GameDTOTransformer()))->handle($query);

        // assert
        $this->assertEquals($expected, $response);
    }

    public function perfectMoves()
    {
        return [
            [
                [
                    ['X', 'X', ''],
                    ['', 'O', ''],
                    ['', '', ''],
                ],
                [
                    ['X', 'X', 'O'],
                    ['', 'O', ''],
                    ['', '', ''],
                ],
            ],
            [
                [
                    ['X', 'X', 'O'],
                    ['', 'O', ''],
                    ['X', '', ''],
                ],
                [
                    ['X', 'X', 'O'],
                    ['O', 'O', ''],
                    ['X', '', ''],
                ],
            ],
            [
                [
                    ['X', 'X', 'O'],
                    ['O', 'O', 'X'],
                    ['X', '', ''],
                ],
                [
                    ['X', 'X', 'O'],
                    ['O', 'O', 'X'],
                    ['X', 'O', ''],
                ],
            ],
        ];
    }
}
