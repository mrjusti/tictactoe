<?php

namespace TicTacToe\Domain\Model;

class Position
{
    /**
     * @var int
     */
    private $row;

    /**
     * @var int
     */
    private $column;

    public function __construct(int $row, int $column)
    {
        $this->row    = $row;
        $this->column = $column;
    }

    /**
     * @return int
     */
    public function row()
    {
        return $this->row;
    }

    /**
     * @return int
     */
    public function column()
    {
        return $this->column;
    }
}
