<?php

namespace TicTacToe\Tests\Behaviour;

use PHPUnit\Framework\TestCase;

class MakeMoveTest extends TestCase
{
    /**
     * @test
     */
    public function given_an_already_finish_game_when_try_next_move_then_must_return_the_original_game_state()
    {
        $this->assertFalse(false);
    }
}
