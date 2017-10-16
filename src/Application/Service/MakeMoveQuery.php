<?php

namespace TicTacToe\Application\Service;

class MakeMoveQuery
{
    private $boardState;

    public function __construct($boardState)
    {
        $this->boardState = $boardState;
    }

    public function boardState()
    {
        return $this->boardState;
    }
}
