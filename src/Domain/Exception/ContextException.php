<?php

namespace TicTacToe\Domain\Exception;

use Throwable;

abstract class ContextException extends \Exception
{
    /**
     * @var array
     */
    private $ctx;

    public function __construct($message = "", $ctx = [], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->ctx = $ctx;
    }

    public function context()
    {
        return $this->ctx;
    }

    public function code()
    {
        return $this->getCode();
    }
}
