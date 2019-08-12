<?php

namespace Api\Services;

use Api\Contracts\ServiceContract;
use Api\Repositories\TournamentRepository;
use Api\Repositories\TournamentMatchRepository;

class TournamentService extends Service implements ServiceContract
{
    
    /**
     *
     * @param \Api\Repositories\TournamentRepository $tournament
     */
    public function __construct(
        TournamentRepository $tournament, 
        TournamentTeamService $teamService, 
        TournamentGroupService $groupService, 
        TournamentMatchService $matchService
    )
    {
        $this->repository = $tournament;
        $this->teamService = $teamService;
        $this->groupService = $groupService;
        $this->matchService = $matchService;
    }

    public function create($name)
    {
        return $this->repository->init([
            'name' => $name,
            'teams' => 80,
            'groups' => 16,
        ])->storeRaw();
    }

    public function simulate($tournamentId)
    {
        $tournament = $this->getTournament($tournamentId);

        $teams = $this->teamService->createTeams($tournament->teams);
        $groups = $this->groupService->createGroups($tournament, $teams);
        $matches = $this->matchService->simulateQualify($tournament, $groups);
        $playoffers = $this->groupService->teamsInPlayoffs($tournament, $matches);
        $this->matchService->simulatePlayoff($tournament, $playoffers);

        return [
            'teams' => [
                'qualify' => $this->teamService->getTeamNames(),
                'playoff' => $this->groupService->getTeamsInPlayoff(),
            ],
            'groups' => $this->groupService->getGroupsAndTeams(),
            'matches' => [
                'qualify' => $this->matchService->getQualifyMatches(),
                'playoff' => $this->matchService->getPlayoffMatches(),
            ],
            'champion' => $this->matchService->getChampion(),
        ];
    }

    public function getTournament($tournament)
    {
        return $this->repository->find($tournament);
    }
}