<?php

namespace App\Http\Controllers;

use App\Bus\CommandBusInterface;
use JavaScript;

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
        $grid = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];
        Javascript::put(['grid' => $grid]);

        return view('welcome');
    }
}