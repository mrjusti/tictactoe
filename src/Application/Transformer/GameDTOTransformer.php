<?php

namespace TicTacToe\Application\Transformer;

use TicTacToe\Domain\Model\State;

class GameDTOTransformer implements GameTransformer
{
    /**
     * @var State
     */
    private $state;

    public function write(State $state): GameTransformer
    {
        $this->state = $state;

        return $this;
    }

    public function read()
    {
        return $this->state->board()->state();
    }
}