<?php

namespace TicTacToe\Domain\Exception;

class InvalidBoardSize extends ContextException
{
    public function __construct(int $size)
    {
        $message = "The board size is invalid";
        parent::__construct($message, ['size' => $size]);
    }
}
