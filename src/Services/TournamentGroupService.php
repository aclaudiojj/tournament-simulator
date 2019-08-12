<?php

namespace Api\Services;

use Api\Contracts\ServiceContract;
use Api\Repositories\TournamentGroupRepository;
use Api\Exceptions\ApiException;
use Api\Services\Groups\Playoff;
use Api\Services\Groups\Qualify;

class TournamentGroupService extends Service implements ServiceContract
{
    
    /**
     *
     * @param \Api\Repositories\TournamentGroupRepository $tournamentGroup
     */
    public function __construct(TournamentGroupRepository $tournamentGroup, Playoff $playoff, Qualify $qualify)
    {
        $this->repository = $tournamentGroup;
        $this->playoff = $playoff;
        $this->qualify = $qualify;
    }

    public function store()
    {
        if (! $this->repository->canBeAddedToGroup($this->request->get('tournament_id'), $this->request->get('name'))) {
            throw new ApiException('Cannot add team to group');
        }

        return parent::store();
    }

    public function createGroups($tournament, $teams)
    {
        $this->repository->clear();

        $this->qualify->init($this->repository);

        return $this->qualify->createGroups($tournament, $teams);
    }

    public function teamsInPlayoffs($tournament, $groupMatches)
    {
        return $this->playoff->teamsInPlayoffs($tournament, $groupMatches);
    }

    public function getGroupsAndTeams()
    {
        return $this->qualify->getTeamsAndGroups();
    }

    public function getTeamsInPlayoff()
    {
        return $this->playoff->getTeams();
    }
}