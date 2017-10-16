<?php

namespace TicTacToe\Application\Service;

use TicTacToe\Application\Transformer\GameTransformer;
use TicTacToe\Domain\Model\Board;
use TicTacToe\Domain\Model\BotPlayer;
use TicTacToe\Domain\Model\Move\PerfectMove;
use TicTacToe\Domain\Model\GameState;
use TicTacToe\Domain\Service\NextMoveMaker;

class MakeMoveQueryHandler
{
    /**
     * @var NextMoveMaker
     */
    private $nextMoveMaker;

    /**
     * @var GameTransformer
     */
    private $transformer;

    /**
     * MakeMoveQueryHandler constructor.
     *
     * @param NextMoveMaker $nextMoveMaker
     * @param GameTransformer $transformer
     */
    public function __construct(NextMoveMaker $nextMoveMaker, GameTransformer $transformer)
    {
        $this->nextMoveMaker = $nextMoveMaker;
        $this->transformer = $transformer;
    }

    /**
     * @param MakeMoveQuery $query
     *
     * @return mixed
     */
    public function handle(MakeMoveQuery $query)
    {
        $gameState = $this->nextMoveMaker->move(
            new GameState(new Board($query->boardState())),
            new BotPlayer(new PerfectMove())
        );

        return $this->transformer->write($gameState)->read();
    }
}
