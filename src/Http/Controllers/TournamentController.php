<?php

namespace Api\Http\Controllers;

use Api\Services\TournamentService;
use Api\Services\TournamentGroupService;
use Api\Services\TournamentTeamService;
use Api\Services\TournamentMatchService;
use Api\Http\Requests\AddTeamToGroupInTournamentRequest;
use Api\Http\Requests\AddMatchResultInTournament;
use Api\Http\Requests\AddTeamToTournamentRequest;

class TournamentController extends ApiController
{

    /**
     *
     * @return void
     */
    public function __construct(TournamentService $tournamentService)
    {
        $this->service = $tournamentService;
    }

    public function addTeamToGroup(AddTeamToGroupInTournamentRequest $request, TournamentGroupService $service)
    {
        return $service->init($request)->store();
    }

    public function addTeamToTournament(AddTeamToTournamentRequest $request, TournamentTeamService $service)
    {
        return $service->init($request)->store();
    }

    public function addMatchReult(AddMatchResultInTournament $request, TournamentMatchService $service)
    {
        return $service->init($request)->store();
    }

    public function simulate($tournamentId, TournamentService $tournamentService)
    {
        return $tournamentService->simulate($tournamentId);
    }
}
