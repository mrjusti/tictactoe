<?php

namespace TicTacToe\Domain\Model;

use Iterator;
use TicTacToe\Domain\Exception\PositionListOnlyCanHavePositionObjects;

class PositionList extends \ArrayIterator implements Iterator
{
    /**
     * PositionList constructor.
     *
     * @param array $positions
     */
    public function __construct(array $positions)
    {
        $this->guard($positions);
        parent::__construct($positions);
    }

    /**
     * True in case that the list is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        $values = $this->getArrayCopy();

        return empty($values);
    }

    /**
     * Guard that all the elements given are Position object
     *
     * @param $positions
     */
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