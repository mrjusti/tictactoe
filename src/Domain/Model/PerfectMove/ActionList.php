<?php

namespace TicTacToe\Domain\Model\PerfectMove;

use Iterator;
use TicTacToe\Domain\Exception\ActionListOnlyCanHaveActionObjects;
use TicTacToe\Domain\Model\Position;
use TicTacToe\Domain\Model\PositionList;
use function Lambdish\Phunctional\map;

class ActionList extends \ArrayIterator implements Iterator
{
    /**
     * ActionList constructor.
     *
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->guard($actions);
        parent::__construct($actions);
    }

    /**
     * @param PositionList $positionList
     *
     * @return ActionList
     */
    public static function createFromPositionList(PositionList $positionList)
    {
        $availableActions = map(
            function (Position $position) {
                $action = new Action($position);

                return $action;
            },
            $positionList->getArrayCopy()
        );

        return new ActionList($availableActions);
    }

    /**
     * Return the Position with the highest score
     *
     * @return Position
     */
    public function maxScoredPosition() : Position
    {
        /** @var Action[] $sort */
        $sort = \Lambdish\Phunctional\sort(
            function (Action $one, Action $other) {
                return $other->score() <=> $one->score();
            },
            $this->getArrayCopy()
        );

        return $sort[0]->position();
    }

    /**
     * Return the Position with the lowest score
     *
     * @return Position
     */
    public function minScoredPosition() : Position
    {
        /** @var Action[] $sort */
        $sort = \Lambdish\Phunctional\sort(
            function (Action $one, Action $other) {
                return $one->score() <=> $other->score();
            },
            $this->getArrayCopy()
        );

        return $sort[0]->position();
    }

    /**
     * @param $actions
     */
    private function guard($actions)
    {
        \Lambdish\Phunctional\each(
            function ($action) {
                if (!$action instanceof Action) {
                    throw new ActionListOnlyCanHaveActionObjects($action);
                }
            },
            $actions
        );
    }
}
