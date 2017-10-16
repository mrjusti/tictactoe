<?php

namespace TicTacToe\Domain\Model;

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

    public function __construct(Position $position)
    {
        $this->position = $position;
        $this->score    = 0;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function applyToGame(Game $game): Game
    {
        $board = $game->board()->markPosition($this->position, $game->turnUnit());
        $depth = $game->nextDepth();
        $turn  = $game->nextTurn();

        return new Game(new GameState($board), $turn, $depth);
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
