<?php

namespace TicTacToe\Domain\Model;

use Iterator;
use TicTacToe\Domain\Exception\PositionListOnlyCanHavePositionObjects;

class PositionList extends \ArrayIterator implements Iterator
{
    public function __construct(array $positions)
    {
        $this->guard($positions);
        parent::__construct($positions);
    }

    public function isEmpty()
    {
        $values = $this->getArrayCopy();

        return empty($values);
    }

    private function guard($positions)
    {
        \Lambdish\Phunctional\each(
            function ($position) {
                if (!$position instanceof Position) {
                    throw new PositionListOnlyCanHavePositionObjects($position);
                }
            },
            $positions
        );
    }
}