<?php

namespace TicTacToe\Domain\Exception;

class InvalidRowSize extends ContextException
{
    public function __construct(int $row, int $size)
    {
        $message = "The row size is invalid";
        parent::__construct($message, ['row' => $row, 'size' => $size]);
    }
}
