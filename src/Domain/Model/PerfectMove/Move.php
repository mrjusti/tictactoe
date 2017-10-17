<?php

namespace TicTacToe\Domain\Model\PerfectMove;

use TicTacToe\Domain\Model\Board;
use TicTacToe\Domain\Model\GameState;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\map;

class Move
{
    /**
     * @var GameState
     */
    private $state;

    /**
     * @var string
     */
    private $turnUnit;

    /**
     * @var int
     */
    private $depth;

    /**
     * I use this in order to optimize the recursion because we avoid to recalculate the score for each move
     *
     * @var array
     */
    private $moves = [];

    /**
     * Move constructor.
     *
     * @param GameState $state
     * @param $turnUnit
     * @param int $depth
     */
    public function __construct(GameState $state, $turnUnit, $depth = 0)
    {
        $this->state    = $state;
        $this->turnUnit = $turnUnit;
        $this->depth    = $depth;
    }

    /**
     * @return ActionList
     */
    public function possibleActions(): ActionList
    {
        // given all the available positions (free cells) I will assign an scored to the position
        $availableActions = ActionList::createFromPositionList($this->board()->availablePositions());

        // get all the possible actions with their respective scores
        $possibleActions = map(
            function (Action $action) {
                $possibleMove = $action->applyToMove($this);
                $action->setScore($this->minMaxValue($possibleMove));

                return $action;
            },
            $availableActions->getArrayCopy()
        );

        return new ActionList($possibleActions);
    }

    /**
     * @param $unit
     *
     * @return bool
     */
    public function isTheTurnOf($unit)
    {
        return $this->turnUnit === $unit;
    }

    /**
     * @return string
     */
    public function turnUnit()
    {
        return $this->turnUnit;
    }

    /**
     * @return int
     */
    public function nextDepth()
    {
        $depth = $this->depth;
        if ($this->isTheTurnOf(GameState::UNIT_HUMAN)) {
            $depth++;
        }

        return $depth;
    }

    /**
     * @return string
     */
    public function nextTurn(): string
    {
        return $this->isTheTurnOf(GameState::UNIT_BOT) ? GameState::UNIT_HUMAN : GameState::UNIT_BOT;
    }

    /**
     * @return Board
     */
    public function board(): Board
    {
        return $this->state->board();
    }

    /**
     * @param Move $move
     *
     * @return int
     */
    private function minMaxValue(Move $move)
    {
        // Because this function is recursive we have to save the scores already calculated because it could achieve
        // the same score by different ways
        $encode = $move->serialize();
        if (isset($this->moves[$encode])) {
            return $this->moves[$encode];
        }

        // if the game is over, return the score!
        if ($move->state->isOver()) {
            $score = $move->score();

            return $score;
        }

        // if the turn is for the human I have to maximize the score, so I start with a minimum value, the opposite
        // for the bot
        $stateScore = ($move->isTheTurnOf(GameState::UNIT_HUMAN)) ? -500 : 500;

        // given the possible moves, I will calculate the min or max score with future possibilities
        $availableNextMoves = $move->possibleMoves();
        each(
            function (Move $nextMove) use ($move, &$stateScore, $encode) {
                // here is the recursive, I will compare scores if it is the turn of the human to maximize or minimize
                // if it is the bot
                $nextScore = $this->minMaxValue($nextMove);
                if ($move->isTheTurnOf(GameState::UNIT_HUMAN)) {
                    if ($nextScore > $stateScore) {
                        $stateScore = $nextScore;
                    }
                } else {
                    if ($nextScore < $stateScore) {
                        $stateScore = $nextScore;
                    }
                }
            },
            $availableNextMoves
        );
        $this->moves[$encode] = $stateScore;

        return $stateScore;
    }

    /**
     * @return array
     */
    private function possibleMoves()
    {
        $possibleActions    = ActionList::createFromPositionList($this->board()->availablePositions());
        $availableNextMoves = map(
            function (Action $action) {
                $possibleMove = $action->applyToMove($this);

                return $possibleMove;
            },
            $possibleActions->getArrayCopy()
        );

        return $availableNextMoves;
    }

    /**
     * @return string
     */
    private function serialize()
    {
        return json_encode($this->board()->state());
    }

    /**
     * @return int
     */
    private function score()
    {
        switch ($this->state->status()) {
            case GameState::STATUS_WIN_HUMAN:
                $score = 10 - $this->depth;
                break;
            case GameState::STATUS_WIN_BOT:
                $score = -10 + $this->depth;
                break;
            default:
                $score = 0;
        }

        return $score;
    }
}
