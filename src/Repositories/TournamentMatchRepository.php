<?php

namespace Api\Repositories;

use Api\Entities\TournamentMatch;
use Illuminate\Database\Eloquent\Model;
use Api\Http\Resources\TournamentMatch as TournamentMatchResource;
use Api\Http\Resources\TournamentMatches as TournamentMatchesResource;
use Api\Http\Resources\Api as ApiResource;
use Api\Http\Resources\ApiCollection as ApiResources;
use Illuminate\Database\Eloquent\Collection;

class TournamentMatchRepository extends Repository
{   

    /**
     *
     * @param  \Api\Entities\TournamentMatch $tournament
     */
    public function __construct(TournamentMatch $tournamentMatch)
    {
        $this->model = $tournamentMatch;
    }

    public function clear()
    {
        \DB::delete('delete from tournament_games');
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\Api
     */
    public function resource(Model $tournament) : ApiResource
    {
        return new TournamentMatchResource($tournament);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\ApiCollection
     */
    public function resources($tournaments) : ApiResources
    {
        return new TournamentMatchesResource($tournaments);
    }

}