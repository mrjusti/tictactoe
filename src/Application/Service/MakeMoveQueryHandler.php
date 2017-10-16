<?php

namespace TicTacToe\Application\Service;

use TicTacToe\Application\Transformer\GameTransformer;
use TicTacToe\Domain\Model\Board;
use TicTacToe\Domain\Model\BotPlayer;
use TicTacToe\Domain\Model\PerfectMove\PerfectMoveStrategy;
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
        $this->transformer   = $transformer;
    }

    /**
     * @param MakeMoveQuery $query
     *
     * @return mixed
     */
    public function handle(MakeMoveQuery $query)
    {
        // Instantiate the bot player with the perfect move strategy
        $botPlayer = new BotPlayer(new PerfectMoveStrategy());
        $gameState = new GameState(new Board($query->boardState()));

        // get the new game state
        $gameState = $this->nextMoveMaker->move($gameState, $botPlayer);

        return $this->transformer->write($gameState)->read();
    }
}
