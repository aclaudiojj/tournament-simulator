<?php

namespace App\Services;

use \Api\Services\TournamentService as TournamentSimulatorService;

class TournamentService
{

    private $tournamentSimulatorService;

    public function __construct(TournamentSimulatorService $tournamentSimulatorService)
    {
        $this->tournamentSimulatorService = $tournamentSimulatorService;
    }

    public function create($name)
    {
        return $this->tournamentSimulatorService->create($name);
    }   

    public function simulate($tournamentId)
    {
        return $this->tournamentSimulatorService->simulate($tournamentId);
    }
}