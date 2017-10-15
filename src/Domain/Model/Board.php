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

    public function __construct(array $state)
    {
        $this->guard($state);
        $this->state = $state;
    }

    public function state() : array
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function availablePositions()
    {
        $positions = [];
        foreach ($this->state as $row => $values) {
            foreach ($values as $column => $field) {
                if (empty($field)) {
                    $positions[] = new Position($row, $column);
                }
            }
        }

        return $positions;
    }

    public function hasAllFieldsTaken(): bool
    {
        $availablePositions = $this->availablePositions();

        return empty($availablePositions);
    }

    public function getUnitWithAllFieldsInARowEqual()
    {
        return $this->getUnitWithAllValuesEqual($this->state);
    }

    public function getUnitWithAllFieldsInAColumnEqual()
    {
        return $this->getUnitWithAllValuesEqual($this->flipArray($this->state));
    }


    public function getUnitWithAllFieldsInADiagonalEqual()
    {   return $this->getUnitWithAllValuesEqual(
            [
                [$this->state[0][0], $this->state[1][1], $this->state[2][2]],
                [$this->state[2][0], $this->state[1][1], $this->state[0][2]],
            ]
        );
    }

    public function markPosition(Position $position, string $unit): Board
    {
        if (!$this->isPositionFree($position)) {
            throw new PositionIsAlreadyTaken($position->row(), $position->column());
        }

        $state = $this->state();
        $state[$position->row()][$position->column()] = $unit;

        return new self($state);
    }

    private function isPositionFree(Position $position)
    {
        return empty($this->state[$position->row()][$position->column()]);
    }

    private function guard(array $state)
    {
        $size = count($state);
        if ($size !== 3) {
            throw new InvalidBoardSize($size);
        }

        each(
            function ($row, $which) {
                $size = count($row);
                if ($size !== 3) {
                    throw new InvalidRowSize($which, $size);
                }
            },
            $state
        );
    }

    private function getUnitWithAllValuesEqual($values)
    {
        return reduce(
            function ($reduce, $row) {
                $unique = array_unique($row);
                if (count($unique) === 1 && !empty($unique[0])) {
                    $reduce =  $unique[0];
                }

                return $reduce;
            },
            $values,
            null
        );
    }

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
