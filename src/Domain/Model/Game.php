<?php

namespace TicTacToe\Domain\Model;

class Game
{
    /**
     * @var GameState
     */
    private $state;

    /**
     * @var string
     */
    private $turnUnit;

    /**
     * @var int
     */
    private $depth;

    public function __construct(GameState $state, $turnUnit, $depth = 0)
    {
        $this->state    = $state;
        $this->turnUnit = $turnUnit;
        $this->depth    = $depth;
    }

    /**
     * @return bool
     */
    public function isOver()
    {
        return $this->state->isOver();
    }

    /**
     * @return string
     */
    public function turnUnit(): string
    {
        return $this->turnUnit;
    }

    /**
     * @return int
     */
    public function state(): int
    {
        return $this->state->status();
    }

    /**
     * @return Board
     */
    public function board(): Board
    {
        return $this->state->board();
    }

    /**
     * @return int
     */
    public function depth(): int
    {
        return $this->depth;
    }

    public function nextDepth()
    {
        $depth = $this->depth();
        if ($this->turnUnit() == GameState::UNIT_HUMAN) {
            $depth++;
        }

        return $depth;
    }

    public function nextTurn(): string
    {
        return $this->turnUnit() === GameState::UNIT_BOT ? GameState::UNIT_HUMAN : GameState::UNIT_BOT;
    }
}
