<?php

namespace TicTacToe\Domain\Model;

class State
{
    /**
     * @var Board
     */
    private $board;

    /**
     * @var int
     */
    private $status;

    const STATUS_RUNNING = 1;

    const STATUS_DRAW = 2;

    const STATUS_WIN_BOT = 3;

    const STATUS_WIN_HUMAN = 4;

    const UNIT_HUMAN = 'X';

    const UNIT_BOT= 'O';

    public function __construct(Board $board)
    {
        $this->board = $board;
        $this->init();
    }

    /**
     * @return bool
     */
    public function isOver()
    {
        return $this->status != self::STATUS_RUNNING;
    }

    /**
     * @return int
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * @return Board
     */
    public function board(): Board
    {
        return $this->board;
    }

    public function setBoard($newBoard): State
    {
        return new self($newBoard);
    }

    private function init()
    {
        $this->status            = self::STATUS_RUNNING;
        $unitWithAllFieldsInARow = $this->board->getUnitWithAllFieldsInARowEqual();
        if ($unitWithAllFieldsInARow) {
            $this->status = $this->getWinnerState($unitWithAllFieldsInARow);
        }

        $unitWithAllFieldsInAColumn = $this->board->getUnitWithAllFieldsInAColumnEqual();
        if ($unitWithAllFieldsInAColumn) {
            $this->status = $this->getWinnerState($unitWithAllFieldsInAColumn);
        }

        $unitWithAllFieldsInADiagonal = $this->board->getUnitWithAllFieldsInADiagonalEqual();
        if ($unitWithAllFieldsInADiagonal) {
            $this->status = $this->getWinnerState($unitWithAllFieldsInADiagonal);
        }

        if (
            $this->status != self::STATUS_WIN_BOT &&
            $this->status != self::STATUS_WIN_HUMAN &&
            $this->board->hasAllFieldsTaken()
        ) {
            $this->status = self::STATUS_DRAW;
        }
    }

    private function getWinnerState($unitWinner)
    {
        return self::UNIT_BOT === $unitWinner
            ? self::STATUS_WIN_BOT
            : self::STATUS_WIN_HUMAN;
    }
}
