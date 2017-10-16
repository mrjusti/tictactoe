<?php

namespace TicTacToe\Domain\Exception;

class PositionListOnlyCanHavePositionObjects extends ContextException
{
    public function __construct($position)
    {
        $message = "The position list only can have position objects";
        parent::__construct($message, ['position' => $position]);
    }
}
