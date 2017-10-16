<?php

namespace TicTacToe\Domain\Model\Move;

use TicTacToe\Domain\Model\Action;
use TicTacToe\Domain\Model\ActionList;
use TicTacToe\Domain\Model\Board;
use TicTacToe\Domain\Model\Game;
use TicTacToe\Domain\Model\MoveInterface;
use TicTacToe\Domain\Model\Position;
use TicTacToe\Domain\Model\GameState;
use function Lambdish\Phunctional\map;

class PerfectMove implements MoveInterface
{
    /**
     * I use this in order to optimize the recursion in order to avoid calculate
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
        $game  = new Game(new GameState($board), $playerUnit);

        // get all the possible actions with their respective scores
        $possibleActions = $this->possibleActions($game);

        // get the better position (max or min score)
        $position = $game->turnUnit() === GameState::UNIT_HUMAN
            ? $possibleActions->maxScoredPosition()
            : $possibleActions->minScoredPosition();

        return [$position->column(), $position->row(), $game->turnUnit()];
    }

    /**
     * @param Game $game
     *
     * @return ActionList
     */
    private function possibleActions(Game $game): ActionList
    {
        // given all the available positions (free cells) I will assign an scored to the position
        $availableActions = ActionList::createFromPositionList($game->board()->availablePositions());

        // get all the possible actions with their respective scores
        $possibleActions = map(
            function (Action $action) use ($game) {
                $possibleGame = $action->applyToGame($game);
                $action->setScore($this->minMaxValue($possibleGame));

                return $action;
            },
            $availableActions->getArrayCopy()
        );

        return new ActionList($possibleActions);
    }

    /**
     * @param Game $game
     *
     * @return int
     */
    private function minMaxValue(Game $game)
    {
        // Because this function is recursive we have to save the scores already calculated because it could achieve
        // the same score by different ways
        $encode = $this->serialize($game);
        if (isset($this->games[$encode])) {
            return $this->games[$encode];
        }

        // if game is over, return the score!
        if ($game->isOver()) {
            $score = $this->score($game);

            return $score;
        }

        // If the turn is for the humman I have to maximize the score, so I start with a minimum value, the opposite
        // for the bot
        $stateScore = ($game->turnUnit() === GameState::UNIT_HUMAN) ? -500 : 500;

        // given the possible games, I will calculate the min or max score with future possibilities
        $availableNextGames = $this->possibleGames($game);
        \Lambdish\Phunctional\each(
            function (Game $nextGame) use ($game, &$stateScore, $encode) {
                // here is the recursive, I will compare scores if it is the turn of the human to maximize or minimize
                // if it is the bot
                $nextScore = $this->minMaxValue($nextGame);
                if ($game->turnUnit() === GameState::UNIT_HUMAN) {
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

    /**
     * @param Game $game
     *
     * @return array
     */
    private function possibleGames(Game $game)
    {
        $possibleActions    = ActionList::createFromPositionList($game->board()->availablePositions());
        $availableNextGames = map(
            function (Action $action) use ($game) {
                $possibleAction = $action->applyToGame($game);

                return $possibleAction;
            },
            $possibleActions->getArrayCopy()
        );

        return $availableNextGames;
    }

    /**
     * @param Game $game
     *
     * @return int
     */
    private function score(Game $game)
    {
        switch ($game->state()) {
            case GameState::STATUS_WIN_HUMAN:
                $score = 10 - $game->depth();
                break;
            case GameState::STATUS_WIN_BOT:
                $score = -10 + $game->depth();
                break;
            default:
                $score = 0;
        }

        return $score;
    }

    /**
     * @param Game $game
     *
     * @return string
     */
    private function serialize(Game $game)
    {
        return json_encode($game->board()->state());
    }
}
