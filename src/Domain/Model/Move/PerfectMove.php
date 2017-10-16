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
     * I use this in order to optimize the recursivite in order to avoid calculate
     * more than one the score of a game
     *
     * @var array
     */
    private $games = [];

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
            $availablePositions->getArrayCopy()
        );

        if ($game->turnUnit() === State::UNIT_HUMAN) {
            $position = $this->maxPosition($availableActions);
        } else {
            $position = $this->minPosition($availableActions);
        }

        return [$position->column(), $position->row(), $game->turnUnit()];
    }

    private function minMaxValue(Game $game)
    {
        $encode = json_encode($game->board()->state());
        if (isset($this->games[$encode])) {
            return $this->games[$encode];
        }

        if ($game->isOver()) {
            $score = $this->score($game);

            return $score;
        }

        $stateScore = ($game->turnUnit() === State::UNIT_HUMAN) ? -1000 : 1000;
        $availablePositions = $game->board()->availablePositions();
        $availableNextGames = map(
            function (Position $position) use ($game) {
                $action         = new Action($position);
                $possibleAction = $action->applyToGame($game);

                return $possibleAction;
            },
            $availablePositions->getArrayCopy()
        );

        $turn = $game->turnUnit();
        \Lambdish\Phunctional\each(
            function (Game $nextGame) use ($turn, &$stateScore, $encode) {
                $nextScore = $this->minMaxValue($nextGame);
                if ($turn === State::UNIT_HUMAN) {
                    if ($nextScore > $stateScore) {
                        $stateScore = $nextScore;
                    }
                } else {
                    if ($nextScore < $stateScore) {
                        $stateScore = $nextScore;
                    }
                }
                $this->games[$encode] = $stateScore;

            },
            $availableNextGames
        );

        return $stateScore;
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
