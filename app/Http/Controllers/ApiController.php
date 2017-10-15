<?php

namespace App\Http\Controllers;

use App\Bus\CommandBusInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TicTacToe\Application\Service\MakeMoveQuery;

class ApiController extends Controller
{
    /**
     * @var CommandBusInterface
     */
    private $bus;

    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function next(Request $request)
    {
        $query = new MakeMoveQuery($request->get('grid'), 'X');
        $response = $this->bus->dispatch($query);

        return response($response, Response::HTTP_ACCEPTED);
    }
}