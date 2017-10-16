<?php

namespace TicTacToe\Domain\Model\PerfectMove;

use TicTacToe\Domain\Model\GameState;
use TicTacToe\Domain\Model\Position;

class Action
{
    /**
     * @var Position
     */
    private $position;

    /**
     * @var int
     */
    private $score;

    /**
     * Action constructor.
     *
     * @param Position $position
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
        $this->score    = 0;
    }

    /**
     * Each action has an score in order to evaluate if it is good or not
     *
     * @param $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * Return a new move applying the action
     *
     * @param Move $move
     *
     * @return Move
     */
    public function applyToMove(Move $move): Move
    {
        $board = $move->board()->markPosition($this->position, $move->turnUnit());
        $depth = $move->nextDepth();
        $turn  = $move->nextTurn();

        return new Move(new GameState($board), $turn, $depth);
    }

    /**
     * @return Position
     */
    public function position(): Position
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function score(): int
    {
        return $this->score;
    }
}
