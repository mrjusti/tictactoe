<?php

namespace TicTacToe\Domain\Model;

class BotPlayer
{
    /**
     * @var MoveInterface
     */
    private $moveStrategy;

    /**
     * @var string
     */
    private $unit;

    /**
     * BotPlayer constructor.
     *
     * @param MoveInterface $moveStrategy Strategy with the difficulty of the next move
     */
    public function __construct(MoveInterface $moveStrategy)
    {
        $this->moveStrategy = $moveStrategy;
        $this->unit         = GameState::UNIT_BOT;
    }

    /**
     * @return string
     */
    public function unit(): string
    {
        return $this->unit;
    }

    /**
     * @param GameState $state
     *
     * @return GameState
     */
    public function move(GameState $state): GameState
    {
        $board    = $state->board();
        $position = $this->moveStrategy->makeMove($board->state(), $this->unit());
        $newBoard = $board->markPosition(
            new Position($position[1], $position[0]),
            $this->unit()
        );

        return $state->updateBoard($newBoard);
    }
}
