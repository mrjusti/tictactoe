<?php

namespace App\Http\Controllers;

use App\Bus\CommandBusInterface;

class HomeController extends Controller
{
    /**
     * @var CommandBusInterface
     */
    private $bus;

    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function index()
    {
        return view('welcome');
    }
}