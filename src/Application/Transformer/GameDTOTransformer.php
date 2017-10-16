<?php

namespace TicTacToe\Application\Transformer;

use TicTacToe\Domain\Model\GameState;

class GameDTOTransformer implements GameTransformer
{
    /**
     * @var GameState
     */
    private $state;

    public function write(GameState $state): GameTransformer
    {
        $this->state = $state;

        return $this;
    }

    public function read()
    {
        return [
            'grid'   => $this->state->board()->state(),
            'status' => $this->state->status(),
        ];
    }
}