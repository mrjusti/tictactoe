<?php

namespace Tests\Acceptance;

use Tests\TestCase;

class MakeMoveTest extends TestCase
{
    /**
     * @test
     */
    public function given_a_finish_game_when_call_make_move_then_must_return_the_same_game_state()
    {
        // arrange
        $state = [
            ['O', 'O', 'X'],
            ['', 'X', 'O'],
            ['X', '', ''],
        ];

        // act
        $response = $this->post('/api/play', ['grid' => $state]);

        // assert
        $this->assertEquals(202, $response->status());
        $content = json_decode($response->content(), true);
        $this->assertEquals($state, $content['grid']);
        $this->assertEquals(4, $content['status']);
    }

    /**
     * @test
     */
    public function given_a_board_state_when_call_make_move_then_must_return_the_new_game_state()
    {
        // arrange
        $state = [
            ['X', 'X', 'O'],
            ['O', 'O', 'X'],
            ['X', '', ''],
        ];

        // act
        $response = $this->post('/api/play', ['grid' => $state]);

        // assert
        $this->assertEquals(202, $response->status());
        $expected = [
            ['X', 'X', 'O'],
            ['O', 'O', 'X'],
            ['X', 'O', ''],
        ];
        $content = json_decode($response->content(), true);
        $this->assertEquals($expected, $content['grid']);
    }

    /**
     * @test
     */
    public function given_a_board_when_call_next_move_then_must_return_the_winner()
    {
        // arrange
        $state = [
            ['X', 'X', 'O'],
            ['O', 'O', ''],
            ['X', 'X', ''],
        ];

        // act
        $response = $this->post('/api/play', ['grid' => $state]);

        // assert
        $this->assertEquals(202, $response->status());
        $content = json_decode($response->content(), true);
        $this->assertEquals(3, $content['status']);
    }
}
