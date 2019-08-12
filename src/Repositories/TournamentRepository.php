<?php

namespace Api\Repositories;

use Api\Entities\Tournament;
use Illuminate\Database\Eloquent\Model;
use Api\Http\Resources\Tournament as TournamentResource;
use Api\Http\Resources\Tournaments as TournamentsResource;
use Api\Http\Resources\Api as ApiResource;
use Api\Http\Resources\ApiCollection as ApiResources;
use Illuminate\Database\Eloquent\Collection;

class TournamentRepository extends Repository
{   

    /**
     *
     * @param  \Api\Entities\Tournament $tournament
     */
    public function __construct(Tournament $tournament)
    {
        $this->model = $tournament;
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\Api
     */
    public function resource(Model $tournament) : ApiResource
    {
        return new TournamentResource($tournament);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\ApiCollection
     */
    public function resources($tournaments) : ApiResources
    {
        return new TournamentsResource($tournaments);
    }

}