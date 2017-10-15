<?php

namespace TicTacToe\Domain\Exception;

class PositionIsAlreadyTaken extends ContextException
{
    public function __construct(int $row, int $column)
    {
        $message = "The position is already taken";
        parent::__construct($message, ['row' => $row, 'column' => $column]);
    }
}
