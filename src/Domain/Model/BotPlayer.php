<?php

namespace TicTacToe\Domain\Model;

class BotPlayer
{
    /**
     * @var MoveInterface
     */
    private $move;

    /**
     * @var string
     */
    private $unit;

    public function __construct(MoveInterface $move)
    {
        $this->move  = $move;
        $this->unit  = State::BOT_UNIT;
    }

    /**
     * @return string
     */
    public function unit(): string
    {
        return $this->unit;
    }

    public function move(State $state): State
    {
        $board = $state->board();
        $position = $this->move->makeMove($board->state(), $this->unit());
        $newBoard = $board->markPosition(
            new Position($position[1], $position[0]),
            $this->unit()
        );

        return $state->setBoard($newBoard);
    }
}
