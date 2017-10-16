<?php

namespace TicTacToe\Domain\Model;

use Iterator;
use TicTacToe\Domain\Exception\ActionListOnlyCanHaveActionObjects;
use function Lambdish\Phunctional\map;

class ActionList extends \ArrayIterator implements Iterator
{
    public function __construct(array $actions)
    {
        $this->guard($actions);
        parent::__construct($actions);
    }

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
