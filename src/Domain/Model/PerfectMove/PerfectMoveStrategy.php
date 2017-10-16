<?php

namespace TicTacToe\Domain\Model\PerfectMove;

use TicTacToe\Domain\Model\Board;
use TicTacToe\Domain\Model\MoveInterface;
use TicTacToe\Domain\Model\GameState;
use function Lambdish\Phunctional\map;

class PerfectMoveStrategy implements MoveInterface
{
    /**
     * Makes a move using the $boardState
     * $boardState contains 2 dimensional array of the game field
     * X represents one team, O - the other team, empty string means field is not yet taken.
     * example
     * [['X', 'O', '']
     * ['X', 'O', 'O']
     * ['', '', '']]
     * Returns an array, containing x and y coordinates for next move, and the unit that now occupies it.
     * Example: [2, 0, 'O'] - upper right corner - O player
     *
     * @param array $boardState  Current board state
     * @param string $playerUnit Player unit representation
     *
     * @return array
     */
    public function makeMove($boardState, $playerUnit = 'X'): array
    {
        // prepare move
        $move  = new Move(new GameState(new Board($boardState)), $playerUnit);

        // get all the possible actions with their respective scores
        // $possibleActions = $this->possibleActions($move);
        $possibleActions = $move->possibleActions();

        // get the better position (max or min score)
        $position = $move->isTheTurnOf(GameState::UNIT_HUMAN)
            ? $possibleActions->maxScoredPosition()
            : $possibleActions->minScoredPosition();

        return [$position->column(), $position->row(), $move->turnUnit()];
    }
}
