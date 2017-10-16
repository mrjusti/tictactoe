<?php

namespace TicTacToe\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Model\PerfectMove\Action;
use TicTacToe\Domain\Model\PerfectMove\ActionList;
use TicTacToe\Domain\Model\Position;

class ActionListTest extends TestCase
{
    /**
     * @test
     * @expectedException TicTacToe\Domain\Exception\ActionListOnlyCanHaveActionObjects
     * @dataProvider invalidActions
     */
    public function given_not_action_then_must_throw_an_exception($actions)
    {
        new ActionList($actions);
    }

    public function invalidActions()
    {
        return [
            [['asd']],
            [[new \stdClass()]],
        ];
    }

    /**
     * @test
     */
    public function given_a_list_then_must_return_the_max_scored_position()
    {
        // arrange
        $first = new Action(new Position(1, 1));
        $first->setScore(5);
        $secondPosition = new Position(2, 2);
        $second = new Action($secondPosition);
        $second->setScore(8);
        $actions = new ActionList([$first, $second]);

        // act
        $position = $actions->maxScoredPosition();

        // assert
        $this->assertSame($secondPosition, $position);
    }

    /**
     * @test
     */
    public function given_a_list_then_must_return_the_min_scored_position()
    {
        // arrange
        $first = new Action(new Position(1, 1));
        $first->setScore(8);
        $secondPosition = new Position(2, 2);
        $second = new Action($secondPosition);
        $second->setScore(5);
        $actions = new ActionList([$first, $second]);

        // act
        $position = $actions->minScoredPosition();

        // assert
        $this->assertSame($secondPosition, $position);
    }
}
