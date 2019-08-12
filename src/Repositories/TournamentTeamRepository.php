<?php

namespace Api\Repositories;

use Api\Entities\TournamentTeam;
use Illuminate\Database\Eloquent\Model;
use Api\Http\Resources\TournamentTeam as TournamentTeamResource;
use Api\Http\Resources\TournamentTeams as TournamentTeamsResource;
use Api\Http\Resources\Api as ApiResource;
use Api\Http\Resources\ApiCollection as ApiResources;
use Illuminate\Database\Eloquent\Collection;

class TournamentTeamRepository extends Repository
{   

    /**
     *
     * @param  \Api\Entities\TournamentTeam $tournament
     */
    public function __construct(TournamentTeam $tournamentTeam)
    {
        $this->model = $tournamentTeam;
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\Api
     */
    public function resource(Model $tournament) : ApiResource
    {
        return new TournamentTeamResource($tournament);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\ApiCollection
     */
    public function resources($tournaments) : ApiResources
    {
        return new TournamentTeamsResource($tournaments);
    }

}