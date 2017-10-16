<?php

namespace TicTacToe\Domain\Model;

use TicTacToe\Domain\Exception\InvalidBoardSize;
use TicTacToe\Domain\Exception\InvalidRowSize;
use TicTacToe\Domain\Exception\PositionIsAlreadyTaken;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\reduce;

class Board
{
    /**
     * @var array
     */
    private $state;

    const NUMBER_OF_ROWS = 3;

    const NUMBER_OF_COLUMNS = 3;

    /**
     * Board constructor.
     *
     * @param array $state
     */
    public function __construct(array $state)
    {
        $this->guard($state);
        $this->state = $state;
    }

    /**
     * Return a two dimensional array with the state of the board
     *
     * @return array
     */
    public function state(): array
    {
        return $this->state;
    }

    /**
     * Return all the positions that are free
     *
     * @return PositionList
     */
    public function availablePositions(): PositionList
    {
        $positions = [];
        foreach ($this->state as $row => $values) {
            foreach ($values as $column => $field) {
                if (empty($field)) {
                    $positions[] = new Position($row, $column);
                }
            }
        }

        return new PositionList($positions);
    }

    /**
     * Return true in case that all the board is full
     *
     * @return bool
     */
    public function hasAllFieldsTaken(): bool
    {
        return $this->availablePositions()->isEmpty();
    }

    /**
     * Return the unit in a row if is full and has the same unit in all the cells.
     *
     * @return string|null
     */
    public function getUnitWithAllFieldsInARowEqual()
    {
        return $this->getUnitWithAllValuesEqual($this->state);
    }

    /**
     * Return the unit in a column if is full and has the same unit in all the cells.
     *
     * @return string|null
     */
    public function getUnitWithAllFieldsInAColumnEqual()
    {
        return $this->getUnitWithAllValuesEqual($this->flipArray($this->state));
    }

    /**
     * Return the unit in a diagonal if is full and has the same unit in all the cells.
     *
     * @return string|null
     */
    public function getUnitWithAllFieldsInADiagonalEqual()
    {
        return $this->getUnitWithAllValuesEqual(
            [
                [$this->state[0][0], $this->state[1][1], $this->state[2][2]],
                [$this->state[2][0], $this->state[1][1], $this->state[0][2]],
            ]
        );
    }

    /**
     * Mark a cell with the given unit.
     *
     * @param Position $position
     * @param string $unit
     *
     * @return Board
     * @throws PositionIsAlreadyTaken
     */
    public function markPosition(Position $position, string $unit): Board
    {
        if (!$this->isPositionFree($position)) {
            throw new PositionIsAlreadyTaken($position->row(), $position->column());
        }

        $state                                        = $this->state();
        $state[$position->row()][$position->column()] = $unit;

        return new self($state);
    }

    /**
     * True in the case that the cell is empty
     *
     * @param Position $position
     *
     * @return bool
     */
    private function isPositionFree(Position $position)
    {
        return empty($this->state[$position->row()][$position->column()]);
    }

    /**
     * Guard that the given board state is correct
     *
     * @param array $state
     *
     * @throws InvalidBoardSize
     */
    private function guard(array $state)
    {
        $size = count($state);
        if ($size !== self::NUMBER_OF_ROWS) {
            throw new InvalidBoardSize($size);
        }

        each(
            function ($row, $which) {
                $size = count($row);
                if ($size !== self::NUMBER_OF_COLUMNS) {
                    throw new InvalidRowSize($which, $size);
                }
            },
            $state
        );
    }

    /**
     * Return the unique value if all the values from an array are the same an are not empty
     *
     * @param $values
     *
     * @return string|null
     */
    private function getUnitWithAllValuesEqual($values)
    {
        return reduce(
            function ($reduce, $row) {
                $unique = array_unique($row);
                if (count($unique) === 1 && !empty($unique[0])) {
                    $reduce = $unique[0];
                }

                return $reduce;
            },
            $values,
            null
        );
    }

    /**
     * Given a two dimensional array, will return the column in the row, and the row in the column
     *
     * @param $array
     *
     * @return array
     */
    private function flipArray($array)
    {
        $rows        = count($array);
        $rowIndex    = 0;
        $columnIndex = 0;
        $out         = [];

        foreach ($array as $row) {
            foreach ($row as $val) {
                $out[$rowIndex][$columnIndex] = $val;
                $rowIndex++;
                if ($rowIndex >= $rows) {
                    $columnIndex++;
                    $rowIndex = 0;
                }
            }
        }

        return $out;
    }
}
