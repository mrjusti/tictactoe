<?php

namespace TicTacToe\Domain\Model\Move;

use TicTacToe\Domain\Model\Action;
use TicTacToe\Domain\Model\Board;
use TicTacToe\Domain\Model\Game;
use TicTacToe\Domain\Model\MoveInterface;
use TicTacToe\Domain\Model\Position;
use TicTacToe\Domain\Model\State;
use function Lambdish\Phunctional\map;

class PerfectMove implements MoveInterface
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
        $board = new Board($boardState);
        $game  = new Game(new State($board), $playerUnit);

        $availablePositions = $game->board()->availablePositions();
        $availableActions   = map(
            function (Position $position) use ($game) {
                $action       = new Action($position);
                $possibleGame = $action->applyToGame($game);
                $action->setScore($this->minMaxValue($possibleGame));

                return $action;
            },
            $availablePositions
        );

        if ($game->turnUnit() === State::HUMAN_UNIT) {
            $position = $this->maxPosition($availableActions);
        } else {
            $position = $this->minPosition($availableActions);
        }

        return [$position->column(), $position->row(), $game->turnUnit()];
    }

    private function minMaxValue(Game $game)
    {
        if ($game->isOver()) {
            return $this->score($game);
        }

        $stateScore = ($game->turnUnit() === State::HUMAN_UNIT) ? -1000 : 1000;
        $availablePositions = $game->board()->availablePositions();
        $availableNextGames = map(
            function (Position $position) use ($game) {
                $action         = new Action($position);
                $possibleAction = $action->applyToGame($game);

                return $possibleAction;
            },
            $availablePositions
        );

        foreach ($availableNextGames as $nextGame) {
            $nextScore = $this->minMaxValue($nextGame);
            if ($game->turnUnit() === State::HUMAN_UNIT) {
                if ($nextScore > $stateScore) {
                    $stateScore = $nextScore;
                }
            } else {
                if ($nextScore < $stateScore) {
                    $stateScore = $nextScore;
                }
            }

            return $stateScore;
        }
    }

    private function score(Game $game)
    {
        $score = 0;
        switch ($game->state()) {
            case State::STATUS_WIN_HUMAN:
                $score = 10 - $game->depth();
                break;
            case State::STATUS_WIN_BOT:
                $score = -10 + $game->depth();
                break;
        }

        return $score;
    }

    private function maxPosition($availableActions): Position
    {
        $sort = \Lambdish\Phunctional\sort(
            function (Action $one, Action $other) {
                return $other->score() <=> $one->score();
            },
            $availableActions
        );

        return $sort[0]->position();
    }

    private function minPosition($availableActions): Position
    {
        $sort = \Lambdish\Phunctional\sort(
            function (Action $one, Action $other) {
                return $one->score() <=> $other->score();
            },
            $availableActions
        );

        return $sort[0]->position();
    }
}
