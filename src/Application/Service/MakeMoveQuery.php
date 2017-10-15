<?php

namespace TicTacToe\Application\Service;

class MakeMoveQuery
{
    private $boardState;

    private $playerUnit;

    public function __construct($boardState, $playerUnit)
    {
        $this->boardState = $boardState;
        $this->playerUnit = $playerUnit;
    }

    public function boardState()
    {
        return $this->boardState;
    }

    public function playerUnit()
    {
        return $this->playerUnit;
    }
}
