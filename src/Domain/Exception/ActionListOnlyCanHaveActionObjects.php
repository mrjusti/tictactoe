<?php

namespace TicTacToe\Domain\Exception;

class ActionListOnlyCanHaveActionObjects extends ContextException
{
    public function __construct($action)
    {
        $message = "The action list only can have action objects";
        parent::__construct($message, ['action' => $action]);
    }
}
