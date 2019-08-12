<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TournamentService;

class TournamentSimulationController extends Controller
{

    private $tournamentService;

    public function __construct(TournamentService $tournamentService)
    {
        $this->tournamentService = $tournamentService;
    }

    public function simulate()
    {
        return view('simulator', [
            'tournament' => $this->tournamentService->simulate(1)
        ]);
    }
}