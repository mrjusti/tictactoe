<?php

namespace App\Http\Controllers;

use App\Bus\CommandBusInterface;
use Illuminate\Http\Response;

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

    public function nextMove()
    {
        return response('', Response::HTTP_ACCEPTED);
    }
}